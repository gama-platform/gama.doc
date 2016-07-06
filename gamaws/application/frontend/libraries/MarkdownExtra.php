<?php
/**
 * Markdown Extra - A text-to-HTML conversion tool for web writers
 *
 * @package   php-markdown
 * @author    Michel Fortin <michel.fortin@michelf.com>
 * @copyright 2004-2016 Michel Fortin <http://michelf.com/projects/php-markdown/>
 * @copyright (Original Markdown) 2004-2006 John Gruber <http://daringfireball.net/projects/markdown/>
 */


/**
 * Markdown Extra Parser Class
 */
class MarkdownExtra extends Markdown {
  /**
   * Configuration variables
   */

  /**
   * Prefix for footnote ids.
   * @var string
   */
  public $fn_id_prefix = "";

  /**
   * Optional title attribute for footnote links and backlinks.
   * @var string
   */
  public $fn_link_title     = "";
  public $fn_backlink_title = "";

  /**
   * Optional class attribute for footnote links and backlinks.
   * @var string
   */
  public $fn_link_class     = "footnote-ref";
  public $fn_backlink_class = "footnote-backref";

  /**
   * Content to be displayed within footnote backlinks. The default is '↩';
   * the U+FE0E on the end is a Unicode variant selector used to prevent iOS
   * from displaying the arrow character as an emoji.
   * @var string
   */
  public $fn_backlink_html = '&#8617;&#xFE0E;';

  /**
   * Class name for table cell alignment (%% replaced left/center/right)
   * For instance: 'go-%%' becomes 'go-left' or 'go-right' or 'go-center'
   * If empty, the align attribute is used instead of a class name.
   * @var string
   */
  public $table_align_class_tmpl = '';

  /**
   * Optional class prefix for fenced code block.
   * @var string
   */
  public $code_class_prefix = "";

  /**
   * Class attribute for code blocks goes on the `code` tag;
   * setting this to true will put attributes on the `pre` tag instead.
   * @var boolean
   */
  public $code_attr_on_pre = false;

  /**
   * Predefined abbreviations.
   * @var array
   */
  public $predef_abbr = array();

  /**
   * Parser implementation
   */

  /**
   * Constructor function. Initialize the parser object.
   * @return void
   */
  public function __construct() {
    // Add extra escapable characters before parent constructor
    // initialize the table.
    $this->escape_chars .= ':|';

    // Insert extra document, block, and span transformations.
    // Parent constructor will do the sorting.
    $this->document_gamut += array(
        "doFencedCodeBlocks" => 5,
        "stripFootnotes"     => 15,
        "stripAbbreviations" => 25,
        "appendFootnotes"    => 50,
    );
    $this->block_gamut += array(
        "doFencedCodeBlocks" => 5,
        "doTables"           => 15,
        "doDefLists"         => 45,
    );
    $this->span_gamut += array(
        "doFootnotes"        => 5,
        "doAbbreviations"    => 70,
    );

    $this->enhanced_ordered_list = true;
    parent::__construct();
  }


  /**
   * Extra variables used during extra transformations.
   * @var array
   */
  protected $footnotes = array();
  protected $footnotes_ordered = array();
  protected $footnotes_ref_count = array();
  protected $footnotes_numbers = array();
  protected $abbr_desciptions = array();
  /** @var @string */
  protected $abbr_word_re = '';

  /**
   * Give the current footnote number.
   * @var integer
   */
  protected $footnote_counter = 1;

  /**
   * Setting up Extra-specific variables.
   */
  protected function setup() {
    parent::setup();

    $this->footnotes = array();
    $this->footnotes_ordered = array();
    $this->footnotes_ref_count = array();
    $this->footnotes_numbers = array();
    $this->abbr_desciptions = array();
    $this->abbr_word_re = '';
    $this->footnote_counter = 1;

    foreach ($this->predef_abbr as $abbr_word => $abbr_desc) {
      if ($this->abbr_word_re)
        $this->abbr_word_re .= '|';
      $this->abbr_word_re .= preg_quote($abbr_word);
      $this->abbr_desciptions[$abbr_word] = trim($abbr_desc);
    }
  }

  /**
   * Clearing Extra-specific variables.
   */
  protected function teardown() {
    $this->footnotes = array();
    $this->footnotes_ordered = array();
    $this->footnotes_ref_count = array();
    $this->footnotes_numbers = array();
    $this->abbr_desciptions = array();
    $this->abbr_word_re = '';

    parent::teardown();
  }


  /**
   * Extra attribute parser
   */

  /**
   * Expression to use to catch attributes (includes the braces)
   * @var string
   */
  protected $id_class_attr_catch_re = '\{((?>[ ]*[#.a-z][-_:a-zA-Z0-9=]+){1,})[ ]*\}';

  /**
   * Expression to use when parsing in a context when no capture is desired
   * @var string
   */
  protected $id_class_attr_nocatch_re = '\{(?>[ ]*[#.a-z][-_:a-zA-Z0-9=]+){1,}[ ]*\}';

  /**
   * Parse attributes caught by the $this->id_class_attr_catch_re expression
   * and return the HTML-formatted list of attributes.
   *
   * Currently supported attributes are .class and #id.
   *
   * In addition, this method also supports supplying a default Id value,
   * which will be used to populate the id attribute in case it was not
   * overridden.
   * @param  string $tag_name
   * @param  string $attr
   * @param  mixed  $defaultIdValue
   * @param  array  $classes
   * @return string
   */
  protected function doExtraAttributes($tag_name, $attr, $defaultIdValue = null, $classes = array()) {
    if (empty($attr) && !$defaultIdValue && empty($classes)) return "";

    // Split on components
    preg_match_all('/[#.a-z][-_:a-zA-Z0-9=]+/', $attr, $matches);
    $elements = $matches[0];

    // Handle classes and IDs (only first ID taken into account)
    $attributes = array();
    $id = false;
    foreach ($elements as $element) {
      if ($element{0} == '.') {
        $classes[] = substr($element, 1);
      } else if ($element{0} == '#') {
        if ($id === false) $id = substr($element, 1);
      } else if (strpos($element, '=') > 0) {
        $parts = explode('=', $element, 2);
        $attributes[] = $parts[0] . '="' . $parts[1] . '"';
      }
    }

    if (!$id) $id = $defaultIdValue;

    // Compose attributes as string
    $attr_str = "";
    if (!empty($id)) {
      $attr_str .= ' id="'.$this->encodeAttribute($id) .'"';
    }
    if (!empty($classes)) {
      $attr_str .= ' class="'. implode(" ", $classes) . '"';
    }
    if (!$this->no_markup && !empty($attributes)) {
      $attr_str .= ' '.implode(" ", $attributes);
    }
    return $attr_str;
  }

  /**
   * Strips link definitions from text, stores the URLs and titles in
   * hash references.
   * @param  string $text
   * @return string
   */
  protected function stripLinkDefinitions($text) {
    $less_than_tab = $this->tab_width - 1;

    // Link defs are in the form: ^[id]: url "optional title"
    $text = preg_replace_callback('{
              ^[ ]{0,'.$less_than_tab.'}\[(.+)\][ ]?: # id = $1
                [ ]*
                \n?       # maybe *one* newline
                [ ]*
              (?:
                <(.+?)>     # url = $2
              |
                (\S+?)      # url = $3
              )
                [ ]*
                \n?       # maybe one newline
                [ ]*
              (?:
                (?<=\s)     # lookbehind for whitespace
                ["(]
                (.*?)     # title = $4
                [")]
                [ ]*
              )?  # title is optional
          (?:[ ]* '.$this->id_class_attr_catch_re.' )?  # $5 = extra id & class attr
              (?:\n+|\Z)
      }xm',
        array($this, '_stripLinkDefinitions_callback'),
        $text);
    return $text;
  }

  /**
   * Strip link definition callback
   * @param  array $matches
   * @return string
   */
  protected function _stripLinkDefinitions_callback($matches) {
    $link_id = strtolower($matches[1]);
    $url = $matches[2] == '' ? $matches[3] : $matches[2];
    $this->urls[$link_id] = $url;
    $this->titles[$link_id] =& $matches[4];
    $this->ref_attr[$link_id] = $this->doExtraAttributes("", $dummy =& $matches[5]);
    return ''; // String that will replace the block
  }


  /**
   * HTML block parser
   */

  /**
   * Tags that are always treated as block tags
   * @var string
   */
  protected $block_tags_re = 'p|div|h[1-6]|blockquote|pre|table|dl|ol|ul|address|form|fieldset|iframe|hr|legend|article|section|nav|aside|hgroup|header|footer|figcaption|figure';

  /**
   * Tags treated as block tags only if the opening tag is alone on its line
   * @var string
   */
  protected $context_block_tags_re = 'script|noscript|style|ins|del|iframe|object|source|track|param|math|svg|canvas|audio|video';

  /**
   * Tags where markdown="1" default to span mode:
   * @var string
   */
  protected $contain_span_tags_re = 'p|h[1-6]|li|dd|dt|td|th|legend|address';

  /**
   * Tags which must not have their contents modified, no matter where
   * they appear
   * @var string
   */
  protected $clean_tags_re = 'script|style|math|svg';

  /**
   * Tags that do not need to be closed.
   * @var string
   */
  protected $auto_close_tags_re = 'hr|img|param|source|track';

  /**
   * Hashify HTML Blocks and "clean tags".
   *
   * We only want to do this for block-level HTML tags, such as headers,
   * lists, and tables. That's because we still want to wrap <p>s around
   * "paragraphs" that are wrapped in non-block-level tags, such as anchors,
   * phrase emphasis, and spans. The list of tags we're looking for is
   * hard-coded.
   *
   * This works by calling _HashHTMLBlocks_InMarkdown, which then calls
   * _HashHTMLBlocks_InHTML when it encounter block tags. When the markdown="1"
   * attribute is found within a tag, _HashHTMLBlocks_InHTML calls back
   *  _HashHTMLBlocks_InMarkdown to handle the Markdown syntax within the tag.
   * These two functions are calling each other. It's recursive!
   * @param  string $text
   * @return string
   */
  protected function hashHTMLBlocks($text) {
    if ($this->no_markup) {
      return $text;
    }

    // Call the HTML-in-Markdown hasher.
    list($text, ) = $this->_hashHTMLBlocks_inMarkdown($text);

    return $text;
  }

  /**
   * Parse markdown text, calling _HashHTMLBlocks_InHTML for block tags.
   *
   * *   $indent is the number of space to be ignored when checking for code
   *     blocks. This is important because if we don't take the indent into
   *     account, something like this (which looks right) won't work as expected:
   *
   *     <div>
   *         <div markdown="1">
   *         Hello World.  <-- Is this a Markdown code block or text?
   *         </div>  <-- Is this a Markdown code block or a real tag?
   *     <div>
   *
   *     If you don't like this, just don't indent the tag on which
   *     you apply the markdown="1" attribute.
   *
   * *   If $enclosing_tag_re is not empty, stops at the first unmatched closing
   *     tag with that name. Nested tags supported.
   *
   * *   If $span is true, text inside must treated as span. So any double
   *     newline will be replaced by a single newline so that it does not create
   *     paragraphs.
   *
   * Returns an array of that form: ( processed text , remaining text )
   *
   * @param  string  $text
   * @param  integer $indent
   * @param  string  $enclosing_tag_re
   * @param  boolean $span
   * @return array
   */
  protected function _hashHTMLBlocks_inMarkdown($text, $indent = 0,
                                                $enclosing_tag_re = '', $span = false)
  {

    if ($text === '') return array('', '');

    // Regex to check for the presense of newlines around a block tag.
    $newline_before_re = '/(?:^\n?|\n\n)*$/';
    $newline_after_re =
        '{
        ^           # Start of text following the tag.
        (?>[ ]*<!--.*?-->)?   # Optional comment.
        [ ]*\n          # Must be followed by newline.
      }xs';

    // Regex to match any tag.
    $block_tag_re =
        '{
        (         # $2: Capture whole tag.
          </?         # Any opening or closing tag.
            (?>       # Tag name.
              ' . $this->block_tags_re . '      |
              ' . $this->context_block_tags_re . '  |
              ' . $this->clean_tags_re . '          |
              (?!\s)'.$enclosing_tag_re . '
            )
            (?:
              (?=[\s"\'/a-zA-Z0-9]) # Allowed characters after tag name.
              (?>
                ".*?"   | # Double quotes (can contain `>`)
                \'.*?\'     | # Single quotes (can contain `>`)
                .+?       # Anything but quotes and `>`.
              )*?
            )?
          >         # End of tag.
        |
          <!--    .*?     --> # HTML Comment
        |
          <\?.*?\?> | <%.*?%> # Processing instruction
        |
          <!\[CDATA\[.*?\]\]> # CData Block
        ' . ( !$span ? ' # If not in span.
        |
          # Indented code block
          (?: ^[ ]*\n | ^ | \n[ ]*\n )
          [ ]{' . ($indent + 4) . '}[^\n]* \n
          (?>
            (?: [ ]{' . ($indent + 4) . '}[^\n]* | [ ]* ) \n
          )*
        |
          # Fenced code block marker
          (?<= ^ | \n )
          [ ]{0,' . ($indent + 3) . '}(?:~{3,}|`{3,})
          [ ]*
          (?: \.?[-_:a-zA-Z0-9]+ )? # standalone class name
          [ ]*
          (?: ' . $this->id_class_attr_nocatch_re . ' )? # extra attributes
          [ ]*
          (?= \n )
        ' : '' ) . ' # End (if not is span).
        |
          # Code span marker
          # Note, this regex needs to go after backtick fenced
          # code blocks but it should also be kept outside of the
          # "if not in span" condition adding backticks to the parser
          `+
        )
      }xs';


    $depth = 0;   // Current depth inside the tag tree.
    $parsed = ""; // Parsed text that will be returned.

    // Loop through every tag until we find the closing tag of the parent
    // or loop until reaching the end of text if no parent tag specified.
    do {
      // Split the text using the first $tag_match pattern found.
      // Text before  pattern will be first in the array, text after
      // pattern will be at the end, and between will be any catches made
      // by the pattern.
      $parts = preg_split($block_tag_re, $text, 2,
          PREG_SPLIT_DELIM_CAPTURE);

      // If in Markdown span mode, add a empty-string span-level hash
      // after each newline to prevent triggering any block element.
      if ($span) {
        $void = $this->hashPart("", ':');
        $newline = "$void\n";
        $parts[0] = $void . str_replace("\n", $newline, $parts[0]) . $void;
      }

      $parsed .= $parts[0]; // Text before current tag.

      // If end of $text has been reached. Stop loop.
      if (count($parts) < 3) {
        $text = "";
        break;
      }

      $tag  = $parts[1]; // Tag to handle.
      $text = $parts[2]; // Remaining text after current tag.
      $tag_re = preg_quote($tag); // For use in a regular expression.

      // Check for: Fenced code block marker.
      // Note: need to recheck the whole tag to disambiguate backtick
      // fences from code spans
      if (preg_match('{^\n?([ ]{0,' . ($indent + 3) . '})(~{3,}|`{3,})[ ]*(?:\.?[-_:a-zA-Z0-9]+)?[ ]*(?:' . $this->id_class_attr_nocatch_re . ')?[ ]*\n?$}', $tag, $capture)) {
        // Fenced code block marker: find matching end marker.
        $fence_indent = strlen($capture[1]); // use captured indent in re
        $fence_re = $capture[2]; // use captured fence in re
        if (preg_match('{^(?>.*\n)*?[ ]{' . ($fence_indent) . '}' . $fence_re . '[ ]*(?:\n|$)}', $text,
            $matches))
        {
          // End marker found: pass text unchanged until marker.
          $parsed .= $tag . $matches[0];
          $text = substr($text, strlen($matches[0]));
        }
        else {
          // No end marker: just skip it.
          $parsed .= $tag;
        }
      }
      // Check for: Indented code block.
      else if ($tag{0} == "\n" || $tag{0} == " ") {
        // Indented code block: pass it unchanged, will be handled
        // later.
        $parsed .= $tag;
      }
      // Check for: Code span marker
      // Note: need to check this after backtick fenced code blocks
      else if ($tag{0} == "`") {
        // Find corresponding end marker.
        $tag_re = preg_quote($tag);
        if (preg_match('{^(?>.+?|\n(?!\n))*?(?<!`)' . $tag_re . '(?!`)}',
            $text, $matches))
        {
          // End marker found: pass text unchanged until marker.
          $parsed .= $tag . $matches[0];
          $text = substr($text, strlen($matches[0]));
        }
        else {
          // Unmatched marker: just skip it.
          $parsed .= $tag;
        }
      }
      // Check for: Opening Block level tag or
      //            Opening Context Block tag (like ins and del)
      //               used as a block tag (tag is alone on it's line).
      else if (preg_match('{^<(?:' . $this->block_tags_re . ')\b}', $tag) ||
          ( preg_match('{^<(?:' . $this->context_block_tags_re . ')\b}', $tag) &&
              preg_match($newline_before_re, $parsed) &&
              preg_match($newline_after_re, $text)  )
      )
      {
        // Need to parse tag and following text using the HTML parser.
        list($block_text, $text) =
            $this->_hashHTMLBlocks_inHTML($tag . $text, "hashBlock", true);

        // Make sure it stays outside of any paragraph by adding newlines.
        $parsed .= "\n\n$block_text\n\n";
      }
      // Check for: Clean tag (like script, math)
      //            HTML Comments, processing instructions.
      else if (preg_match('{^<(?:' . $this->clean_tags_re . ')\b}', $tag) ||
          $tag{1} == '!' || $tag{1} == '?')
      {
        // Need to parse tag and following text using the HTML parser.
        // (don't check for markdown attribute)
        list($block_text, $text) =
            $this->_hashHTMLBlocks_inHTML($tag . $text, "hashClean", false);

        $parsed .= $block_text;
      }
      // Check for: Tag with same name as enclosing tag.
      else if ($enclosing_tag_re !== '' &&
          // Same name as enclosing tag.
          preg_match('{^</?(?:' . $enclosing_tag_re . ')\b}', $tag))
      {
        // Increase/decrease nested tag count.
        if ($tag{1} == '/')           $depth--;
        else if ($tag{strlen($tag)-2} != '/') $depth++;

        if ($depth < 0) {
          // Going out of parent element. Clean up and break so we
          // return to the calling function.
          $text = $tag . $text;
          break;
        }

        $parsed .= $tag;
      }
      else {
        $parsed .= $tag;
      }
    } while ($depth >= 0);

    return array($parsed, $text);
  }

  /**
   * Parse HTML, calling _HashHTMLBlocks_InMarkdown for block tags.
   *
   * *   Calls $hash_method to convert any blocks.
   * *   Stops when the first opening tag closes.
   * *   $md_attr indicate if the use of the `markdown="1"` attribute is allowed.
   *     (it is not inside clean tags)
   *
   * Returns an array of that form: ( processed text , remaining text )
   * @param  string $text
   * @param  string $hash_method
   * @param  string $md_attr
   * @return array
   */
  protected function _hashHTMLBlocks_inHTML($text, $hash_method, $md_attr) {
    if ($text === '') return array('', '');

    // Regex to match `markdown` attribute inside of a tag.
    $markdown_attr_re = '
      {
        \s*     # Eat whitespace before the `markdown` attribute
        markdown
        \s*=\s*
        (?>
          (["\'])   # $1: quote delimiter   
          (.*?)   # $2: attribute value
          \1      # matching delimiter  
        |
          ([^\s>]*) # $3: unquoted attribute value
        )
        ()        # $4: make $3 always defined (avoid warnings)
      }xs';

    // Regex to match any tag.
    $tag_re = '{
        (         # $2: Capture whole tag.
          </?         # Any opening or closing tag.
            [\w:$]+     # Tag name.
            (?:
              (?=[\s"\'/a-zA-Z0-9]) # Allowed characters after tag name.
              (?>
                ".*?"   | # Double quotes (can contain `>`)
                \'.*?\'     | # Single quotes (can contain `>`)
                .+?       # Anything but quotes and `>`.
              )*?
            )?
          >         # End of tag.
        |
          <!--    .*?     --> # HTML Comment
        |
          <\?.*?\?> | <%.*?%> # Processing instruction
        |
          <!\[CDATA\[.*?\]\]> # CData Block
        )
      }xs';

    $original_text = $text;   // Save original text in case of faliure.

    $depth    = 0;  // Current depth inside the tag tree.
    $block_text = ""; // Temporary text holder for current text.
    $parsed   = ""; // Parsed text that will be returned.

    // Get the name of the starting tag.
    // (This pattern makes $base_tag_name_re safe without quoting.)
    if (preg_match('/^<([\w:$]*)\b/', $text, $matches))
      $base_tag_name_re = $matches[1];

    // Loop through every tag until we find the corresponding closing tag.
    do {
      // Split the text using the first $tag_match pattern found.
      // Text before  pattern will be first in the array, text after
      // pattern will be at the end, and between will be any catches made
      // by the pattern.
      $parts = preg_split($tag_re, $text, 2, PREG_SPLIT_DELIM_CAPTURE);

      if (count($parts) < 3) {
        // End of $text reached with unbalenced tag(s).
        // In that case, we return original text unchanged and pass the
        // first character as filtered to prevent an infinite loop in the
        // parent function.
        return array($original_text{0}, substr($original_text, 1));
      }

      $block_text .= $parts[0]; // Text before current tag.
      $tag         = $parts[1]; // Tag to handle.
      $text        = $parts[2]; // Remaining text after current tag.

      // Check for: Auto-close tag (like <hr/>)
      //       Comments and Processing Instructions.
      if (preg_match('{^</?(?:' . $this->auto_close_tags_re . ')\b}', $tag) ||
          $tag{1} == '!' || $tag{1} == '?')
      {
        // Just add the tag to the block as if it was text.
        $block_text .= $tag;
      }
      else {
        // Increase/decrease nested tag count. Only do so if
        // the tag's name match base tag's.
        if (preg_match('{^</?' . $base_tag_name_re . '\b}', $tag)) {
          if ($tag{1} == '/')           $depth--;
          else if ($tag{strlen($tag)-2} != '/') $depth++;
        }

        // Check for `markdown="1"` attribute and handle it.
        if ($md_attr &&
            preg_match($markdown_attr_re, $tag, $attr_m) &&
            preg_match('/^1|block|span$/', $attr_m[2] . $attr_m[3]))
        {
          // Remove `markdown` attribute from opening tag.
          $tag = preg_replace($markdown_attr_re, '', $tag);

          // Check if text inside this tag must be parsed in span mode.
          $this->mode = $attr_m[2] . $attr_m[3];
          $span_mode = $this->mode == 'span' || $this->mode != 'block' &&
              preg_match('{^<(?:' . $this->contain_span_tags_re . ')\b}', $tag);

          // Calculate indent before tag.
          if (preg_match('/(?:^|\n)( *?)(?! ).*?$/', $block_text, $matches)) {
            $strlen = $this->utf8_strlen;
            $indent = $strlen($matches[1], 'UTF-8');
          } else {
            $indent = 0;
          }

          // End preceding block with this tag.
          $block_text .= $tag;
          $parsed .= $this->$hash_method($block_text);

          // Get enclosing tag name for the ParseMarkdown function.
          // (This pattern makes $tag_name_re safe without quoting.)
          preg_match('/^<([\w:$]*)\b/', $tag, $matches);
          $tag_name_re = $matches[1];

          // Parse the content using the HTML-in-Markdown parser.
          list ($block_text, $text)
              = $this->_hashHTMLBlocks_inMarkdown($text, $indent,
              $tag_name_re, $span_mode);

          // Outdent markdown text.
          if ($indent > 0) {
            $block_text = preg_replace("/^[ ]{1,$indent}/m", "",
                $block_text);
          }

          // Append tag content to parsed text.
          if (!$span_mode)  $parsed .= "\n\n$block_text\n\n";
          else        $parsed .= "$block_text";

          // Start over with a new block.
          $block_text = "";
        }
        else $block_text .= $tag;
      }

    } while ($depth > 0);

    // Hash last block text that wasn't processed inside the loop.
    $parsed .= $this->$hash_method($block_text);

    return array($parsed, $text);
  }

  /**
   * Called whenever a tag must be hashed when a function inserts a "clean" tag
   * in $text, it passes through this function and is automaticaly escaped,
   * blocking invalid nested overlap.
   * @param  string $text
   * @return string
   */
  protected function hashClean($text) {
    return $this->hashPart($text, 'C');
  }

  /**
   * Turn Markdown link shortcuts into XHTML <a> tags.
   * @param  string $text
   * @return string
   */
  protected function doAnchors($text) {
    if ($this->in_anchor) {
      return $text;
    }
    $this->in_anchor = true;

    // First, handle reference-style links: [link text] [id]
    $text = preg_replace_callback('{
      (         # wrap whole match in $1
        \[
        (' . $this->nested_brackets_re . ') # link text = $2
        \]

        [ ]?        # one optional space
        (?:\n[ ]*)?   # one optional newline followed by spaces

        \[
        (.*?)   # id = $3
        \]
      )
      }xs',
        array($this, '_doAnchors_reference_callback'), $text);

    // Next, inline-style links: [link text](url "optional title")
    $text = preg_replace_callback('{
      (       # wrap whole match in $1
        \[
        (' . $this->nested_brackets_re . ') # link text = $2
        \]
        \(      # literal paren
        [ \n]*
        (?:
          <(.+?)> # href = $3
        |
          (' . $this->nested_url_parenthesis_re . ')  # href = $4
        )
        [ \n]*
        (     # $5
          ([\'"]) # quote char = $6
          (.*?)   # Title = $7
          \6    # matching quote
          [ \n]*  # ignore any spaces/tabs between closing quote and )
        )?      # title is optional
        \)
        (?:[ ]? ' . $this->id_class_attr_catch_re . ' )?   # $8 = id/class attributes
      )
      }xs',
        array($this, '_doAnchors_inline_callback'), $text);

    // Last, handle reference-style shortcuts: [link text]
    // These must come last in case you've also got [link text][1]
    // or [link text](/foo)
    $text = preg_replace_callback('{
      (         # wrap whole match in $1
        \[
        ([^\[\]]+)    # link text = $2; can\'t contain [ or ]
        \]
      )
      }xs',
        array($this, '_doAnchors_reference_callback'), $text);

    $this->in_anchor = false;
    return $text;
  }

  /**
   * Callback for reference anchors
   * @param  array $matches
   * @return string
   */
  protected function _doAnchors_reference_callback($matches) {
    $whole_match =  $matches[1];
    $link_text   =  $matches[2];
    $link_id     =& $matches[3];

    if ($link_id == "") {
      // for shortcut links like [this][] or [this].
      $link_id = $link_text;
    }

    // lower-case and turn embedded newlines into spaces
    $link_id = strtolower($link_id);
    $link_id = preg_replace('{[ ]?\n}', ' ', $link_id);

    if (isset($this->urls[$link_id])) {
      $url = $this->urls[$link_id];
      $url = $this->encodeURLAttribute($url);

      $result = "<a href=\"$url\"";
      if ( isset( $this->titles[$link_id] ) ) {
        $title = $this->titles[$link_id];
        $title = $this->encodeAttribute($title);
        $result .=  " title=\"$title\"";
      }
      if (isset($this->ref_attr[$link_id]))
        $result .= $this->ref_attr[$link_id];

      $link_text = $this->runSpanGamut($link_text);
      $result .= ">$link_text</a>";
      $result = $this->hashPart($result);
    }
    else {
      $result = $whole_match;
    }
    return $result;
  }

  /**
   * Callback for inline anchors
   * @param  array $matches
   * @return string
   */
  protected function _doAnchors_inline_callback($matches) {
    $whole_match  =  $matches[1];
    $link_text    =  $this->runSpanGamut($matches[2]);
    $url      =  $matches[3] == '' ? $matches[4] : $matches[3];
    $title      =& $matches[7];
    $attr  = $this->doExtraAttributes("a", $dummy =& $matches[8]);

    // if the URL was of the form <s p a c e s> it got caught by the HTML
    // tag parser and hashed. Need to reverse the process before using the URL.
    $unhashed = $this->unhash($url);
    if ($unhashed != $url)
      $url = preg_replace('/^<(.*)>$/', '\1', $unhashed);

    $url = $this->encodeURLAttribute($url);

    $result = "<a href=\"$url\"";
    if (isset($title)) {
      $title = $this->encodeAttribute($title);
      $result .=  " title=\"$title\"";
    }
    $result .= $attr;

    $link_text = $this->runSpanGamut($link_text);
    $result .= ">$link_text</a>";

    return $this->hashPart($result);
  }

  /**
   * Turn Markdown image shortcuts into <img> tags.
   * @param  string $text
   * @return string
   */
  protected function doImages($text) {
    // First, handle reference-style labeled images: ![alt text][id]
    $text = preg_replace_callback('{
      (       # wrap whole match in $1
        !\[
        (' . $this->nested_brackets_re . ')   # alt text = $2
        \]

        [ ]?        # one optional space
        (?:\n[ ]*)?   # one optional newline followed by spaces

        \[
        (.*?)   # id = $3
        \]

      )
      }xs',
        array($this, '_doImages_reference_callback'), $text);

    // Next, handle inline images:  ![alt text](url "optional title")
    // Don't forget: encode * and _
    $text = preg_replace_callback('{
      (       # wrap whole match in $1
        !\[
        (' . $this->nested_brackets_re . ')   # alt text = $2
        \]
        \s?     # One optional whitespace character
        \(      # literal paren
        [ \n]*
        (?:
          <(\S*)> # src url = $3
        |
          (' . $this->nested_url_parenthesis_re . ')  # src url = $4
        )
        [ \n]*
        (     # $5
          ([\'"]) # quote char = $6
          (.*?)   # title = $7
          \6    # matching quote
          [ \n]*
        )?      # title is optional
        \)
        (?:[ ]? ' . $this->id_class_attr_catch_re . ' )?   # $8 = id/class attributes
      )
      }xs',
        array($this, '_doImages_inline_callback'), $text);

    return $text;
  }

  /**
   * Callback for referenced images
   * @param  array $matches
   * @return string
   */
  protected function _doImages_reference_callback($matches) {
    $whole_match = $matches[1];
    $alt_text    = $matches[2];
    $link_id     = strtolower($matches[3]);

    if ($link_id == "") {
      $link_id = strtolower($alt_text); // for shortcut links like ![this][].
    }

    $alt_text = $this->encodeAttribute($alt_text);
    if (isset($this->urls[$link_id])) {
      $url = $this->encodeURLAttribute($this->urls[$link_id]);
      $result = "<img src=\"$url\" alt=\"$alt_text\"";
      if (isset($this->titles[$link_id])) {
        $title = $this->titles[$link_id];
        $title = $this->encodeAttribute($title);
        $result .=  " title=\"$title\"";
      }
      if (isset($this->ref_attr[$link_id]))
        $result .= $this->ref_attr[$link_id];
      $result .= $this->empty_element_suffix;
      $result = $this->hashPart($result);
    }
    else {
      // If there's no such link ID, leave intact:
      $result = $whole_match;
    }

    return $result;
  }

  /**
   * Callback for inline images
   * @param  array $matches
   * @return string
   */
  protected function _doImages_inline_callback($matches) {
    $whole_match  = $matches[1];
    $alt_text   = $matches[2];
    $url      = $matches[3] == '' ? $matches[4] : $matches[3];
    $title      =& $matches[7];
    $attr  = $this->doExtraAttributes("img", $dummy =& $matches[8]);

    $alt_text = $this->encodeAttribute($alt_text);
    $url = $this->encodeURLAttribute($url);
    $result = "<img src=\"$url\" alt=\"$alt_text\"";
    if (isset($title)) {
      $title = $this->encodeAttribute($title);
      $result .=  " title=\"$title\""; // $title already quoted
    }
    $result .= $attr;
    $result .= $this->empty_element_suffix;

    return $this->hashPart($result);
  }

  /**
   * Process markdown headers. Redefined to add ID and class attribute support.
   * @param  string $text
   * @return string
   */
  protected function doHeaders($text) {
    // Setext-style headers:
    //  Header 1  {#header1}
    //    ========
    //
    //    Header 2  {#header2 .class1 .class2}
    //    --------
    //
    $text = preg_replace_callback(
        '{
        (^.+?)                # $1: Header text
        (?:[ ]+ ' . $this->id_class_attr_catch_re . ' )?   # $3 = id/class attributes
        [ ]*\n(=+|-+)[ ]*\n+        # $3: Header footer
      }mx',
        array($this, '_doHeaders_callback_setext'), $text);

    // atx-style headers:
    //  # Header 1        {#header1}
    //  ## Header 2       {#header2}
    //  ## Header 2 with closing hashes ##  {#header3.class1.class2}
    //  ...
    //  ###### Header 6   {.class2}
    //
    $text = preg_replace_callback('{
        ^(\#{1,6})  # $1 = string of #\'s
        [ ]*
        (.+?)   # $2 = Header text
        [ ]*
        \#*     # optional closing #\'s (not counted)
        (?:[ ]+ ' . $this->id_class_attr_catch_re . ' )?   # $3 = id/class attributes
        [ ]*
        \n+
      }xm',
        array($this, '_doHeaders_callback_atx'), $text);

    return $text;
  }

  /**
   * Callback for setext headers
   * @param  array $matches
   * @return string
   */
  protected function _doHeaders_callback_setext($matches) {
    if ($matches[3] == '-' && preg_match('{^- }', $matches[1])) {
      return $matches[0];
    }

    $level = $matches[3]{0} == '=' ? 1 : 2;

    $defaultId = is_callable($this->header_id_func) ? call_user_func($this->header_id_func, $matches[1]) : null;

    $attr  = $this->doExtraAttributes("h$level", $dummy =& $matches[2], $defaultId);
    $block = "<h$level$attr>" . $this->runSpanGamut($matches[1]) . "</h$level>";
    return "\n" . $this->hashBlock($block) . "\n\n";
  }

  /**
   * Callback for atx headers
   * @param  array $matches
   * @return string
   */
  protected function _doHeaders_callback_atx($matches) {
    $level = strlen($matches[1]);

    $defaultId = is_callable($this->header_id_func) ? call_user_func($this->header_id_func, $matches[2]) : null;
    $attr  = $this->doExtraAttributes("h$level", $dummy =& $matches[3], $defaultId);
    $block = "<h$level$attr>" . $this->runSpanGamut($matches[2]) . "</h$level>";
    return "\n" . $this->hashBlock($block) . "\n\n";
  }

  /**
   * Form HTML tables.
   * @param  string $text
   * @return string
   */
  protected function doTables($text) {
    $less_than_tab = $this->tab_width - 1;
    // Find tables with leading pipe.
    //
    //  | Header 1 | Header 2
    //  | -------- | --------
    //  | Cell 1   | Cell 2
    //  | Cell 3   | Cell 4
    $text = preg_replace_callback('
      {
        ^             # Start of a line
        [ ]{0,' . $less_than_tab . '} # Allowed whitespace.
        [|]             # Optional leading pipe (present)
        (.+) \n           # $1: Header row (at least one pipe)
        
        [ ]{0,' . $less_than_tab . '} # Allowed whitespace.
        [|] ([ ]*[-:]+[-| :]*) \n # $2: Header underline
        
        (             # $3: Cells
          (?>
            [ ]*        # Allowed whitespace.
            [|] .* \n     # Row content.
          )*
        )
        (?=\n|\Z)         # Stop at final double newline.
      }xm',
        array($this, '_doTable_leadingPipe_callback'), $text);

    // Find tables without leading pipe.
    //
    //  Header 1 | Header 2
    //  -------- | --------
    //  Cell 1   | Cell 2
    //  Cell 3   | Cell 4
    $text = preg_replace_callback('
      {
        ^             # Start of a line
        [ ]{0,' . $less_than_tab . '} # Allowed whitespace.
        (\S.*[|].*) \n        # $1: Header row (at least one pipe)
        
        [ ]{0,' . $less_than_tab . '} # Allowed whitespace.
        ([-:]+[ ]*[|][-| :]*) \n  # $2: Header underline
        
        (             # $3: Cells
          (?>
            .* [|] .* \n    # Row content
          )*
        )
        (?=\n|\Z)         # Stop at final double newline.
      }xm',
        array($this, '_DoTable_callback'), $text);

    return $text;
  }

  /**
   * Callback for removing the leading pipe for each row
   * @param  array $matches
   * @return string
   */
  protected function _doTable_leadingPipe_callback($matches) {
    $head   = $matches[1];
    $underline  = $matches[2];
    $content  = $matches[3];

    $content  = preg_replace('/^ *[|]/m', '', $content);

    return $this->_doTable_callback(array($matches[0], $head, $underline, $content));
  }

  /**
   * Make the align attribute in a table
   * @param  string $alignname
   * @return string
   */
  protected function _doTable_makeAlignAttr($alignname)
  {
    if (empty($this->table_align_class_tmpl)) {
      return " align=\"$alignname\"";
    }

    $classname = str_replace('%%', $alignname, $this->table_align_class_tmpl);
    return " class=\"$classname\"";
  }

  /**
   * Calback for processing tables
   * @param  array $matches
   * @return string
   */
  protected function _doTable_callback($matches) {
    $head   = $matches[1];
    $underline  = $matches[2];
    $content  = $matches[3];

    // Remove any tailing pipes for each line.
    $head   = preg_replace('/[|] *$/m', '', $head);
    $underline  = preg_replace('/[|] *$/m', '', $underline);
    $content  = preg_replace('/[|] *$/m', '', $content);

    // Reading alignement from header underline.
    $separators = preg_split('/ *[|] */', $underline);
    foreach ($separators as $n => $s) {
      if (preg_match('/^ *-+: *$/', $s))
        $attr[$n] = $this->_doTable_makeAlignAttr('right');
      else if (preg_match('/^ *:-+: *$/', $s))
        $attr[$n] = $this->_doTable_makeAlignAttr('center');
      else if (preg_match('/^ *:-+ *$/', $s))
        $attr[$n] = $this->_doTable_makeAlignAttr('left');
      else
        $attr[$n] = '';
    }

    // Parsing span elements, including code spans, character escapes,
    // and inline HTML tags, so that pipes inside those gets ignored.
    $head   = $this->parseSpan($head);
    $headers  = preg_split('/ *[|] */', $head);
    $col_count  = count($headers);
    $attr       = array_pad($attr, $col_count, '');

    // Write column headers.
    $text = "<table>\n";
    $text .= "<thead>\n";
    $text .= "<tr>\n";
    foreach ($headers as $n => $header)
      $text .= "  <th$attr[$n]>" . $this->runSpanGamut(trim($header)) . "</th>\n";
    $text .= "</tr>\n";
    $text .= "</thead>\n";

    // Split content by row.
    $rows = explode("\n", trim($content, "\n"));

    $text .= "<tbody>\n";
    foreach ($rows as $row) {
      // Parsing span elements, including code spans, character escapes,
      // and inline HTML tags, so that pipes inside those gets ignored.
      $row = $this->parseSpan($row);

      // Split row by cell.
      $row_cells = preg_split('/ *[|] */', $row, $col_count);
      $row_cells = array_pad($row_cells, $col_count, '');

      $text .= "<tr>\n";
      foreach ($row_cells as $n => $cell)
        $text .= "  <td$attr[$n]>" . $this->runSpanGamut(trim($cell)) . "</td>\n";
      $text .= "</tr>\n";
    }
    $text .= "</tbody>\n";
    $text .= "</table>";

    return $this->hashBlock($text) . "\n";
  }

  /**
   * Form HTML definition lists.
   * @param  string $text
   * @return string
   */
  protected function doDefLists($text) {
    $less_than_tab = $this->tab_width - 1;

    // Re-usable pattern to match any entire dl list:
    $whole_list_re = '(?>
      (               # $1 = whole list
        (               # $2
        [ ]{0,' . $less_than_tab . '}
        ((?>.*\S.*\n)+)       # $3 = defined term
        \n?
        [ ]{0,' . $less_than_tab . '}:[ ]+ # colon starting definition
        )
        (?s:.+?)
        (               # $4
          \z
        |
          \n{2,}
          (?=\S)
          (?!           # Negative lookahead for another term
          [ ]{0,' . $less_than_tab . '}
          (?: \S.*\n )+?      # defined term
          \n?
          [ ]{0,' . $less_than_tab . '}:[ ]+ # colon starting definition
          )
          (?!           # Negative lookahead for another definition
          [ ]{0,' . $less_than_tab . '}:[ ]+ # colon starting definition
          )
        )
      )
    )'; // mx

    $text = preg_replace_callback('{
        (?>\A\n?|(?<=\n\n))
        ' . $whole_list_re . '
      }mx',
        array($this, '_doDefLists_callback'), $text);

    return $text;
  }

  /**
   * Callback for processing definition lists
   * @param  array $matches
   * @return string
   */
  protected function _doDefLists_callback($matches) {
    // Re-usable patterns to match list item bullets and number markers:
    $list = $matches[1];

    // Turn double returns into triple returns, so that we can make a
    // paragraph for the last item in a list, if necessary:
    $result = trim($this->processDefListItems($list));
    $result = "<dl>\n" . $result . "\n</dl>";
    return $this->hashBlock($result) . "\n\n";
  }

  /**
   * Process the contents of a single definition list, splitting it
   * into individual term and definition list items.
   * @param  string $list_str
   * @return string
   */
  protected function processDefListItems($list_str) {

    $less_than_tab = $this->tab_width - 1;

    // Trim trailing blank lines:
    $list_str = preg_replace("/\n{2,}\\z/", "\n", $list_str);

    // Process definition terms.
    $list_str = preg_replace_callback('{
      (?>\A\n?|\n\n+)           # leading line
      (                 # definition terms = $1
        [ ]{0,' . $less_than_tab . '} # leading whitespace
        (?!\:[ ]|[ ])         # negative lookahead for a definition
                        #   mark (colon) or more whitespace.
        (?> \S.* \n)+?          # actual term (not whitespace). 
      )     
      (?=\n?[ ]{0,3}:[ ])         # lookahead for following line feed 
                        #   with a definition mark.
      }xm',
        array($this, '_processDefListItems_callback_dt'), $list_str);

    // Process actual definitions.
    $list_str = preg_replace_callback('{
      \n(\n+)?              # leading line = $1
      (                 # marker space = $2
        [ ]{0,' . $less_than_tab . '} # whitespace before colon
        \:[ ]+              # definition mark (colon)
      )
      ((?s:.+?))              # definition text = $3
      (?= \n+               # stop at next definition mark,
        (?:               # next term or end of text
          [ ]{0,' . $less_than_tab . '} \:[ ] |
          <dt> | \z
        )           
      )         
      }xm',
        array($this, '_processDefListItems_callback_dd'), $list_str);

    return $list_str;
  }

  /**
   * Callback for <dt> elements in definition lists
   * @param  array $matches
   * @return string
   */
  protected function _processDefListItems_callback_dt($matches) {
    $terms = explode("\n", trim($matches[1]));
    $text = '';
    foreach ($terms as $term) {
      $term = $this->runSpanGamut(trim($term));
      $text .= "\n<dt>" . $term . "</dt>";
    }
    return $text . "\n";
  }

  /**
   * Callback for <dd> elements in definition lists
   * @param  array $matches
   * @return string
   */
  protected function _processDefListItems_callback_dd($matches) {
    $leading_line = $matches[1];
    $marker_space = $matches[2];
    $def      = $matches[3];

    if ($leading_line || preg_match('/\n{2,}/', $def)) {
      // Replace marker with the appropriate whitespace indentation
      $def = str_repeat(' ', strlen($marker_space)) . $def;
      $def = $this->runBlockGamut($this->outdent($def . "\n\n"));
      $def = "\n". $def ."\n";
    }
    else {
      $def = rtrim($def);
      $def = $this->runSpanGamut($this->outdent($def));
    }

    return "\n<dd>" . $def . "</dd>\n";
  }

  /**
   * Adding the fenced code block syntax to regular Markdown:
   *
   * ~~~
   * Code block
   * ~~~
   *
   * @param  string $text
   * @return string
   */
  protected function doFencedCodeBlocks($text) {

    $less_than_tab = $this->tab_width;

    $text = preg_replace_callback('{
        (?:\n|\A)
        # 1: Opening marker
        (
          (?:~{3,}|`{3,}) # 3 or more tildes/backticks.
        )
        [ ]*
        (?:
          \.?([-_:a-zA-Z0-9]+) # 2: standalone class name
        )?
        [ ]*
        (?:
          ' . $this->id_class_attr_catch_re . ' # 3: Extra attributes
        )?
        [ ]* \n # Whitespace and newline following marker.
        
        # 4: Content
        (
          (?>
            (?!\1 [ ]* \n)  # Not a closing marker.
            .*\n+
          )+
        )
        
        # Closing marker.
        \1 [ ]* (?= \n )
      }xm',
        array($this, '_doFencedCodeBlocks_callback'), $text);

    return $text;
  }

  /**
   * Callback to process fenced code blocks
   * @param  array $matches
   * @return string
   */
  protected function _doFencedCodeBlocks_callback($matches) {
    $classname =& $matches[2];
    $attrs     =& $matches[3];
    $codeblock = $matches[4];

    if ($this->code_block_content_func) {
      $codeblock = call_user_func($this->code_block_content_func, $codeblock, $classname);
    } else {
      $codeblock = htmlspecialchars($codeblock, ENT_NOQUOTES);
    }

    # this part is automatically generated, please don't change it
# list of statement
$statementPattern = '/\b(species|global|grid|model|import|output|action|add|agents|annealing|ask|aspect|assert|break|camera|capture|chart|create|data|datalist|default|diffuse|display|display_grid|display_population|do|draw|else|enter|equation|error|event|exhaustive|exit|experiment|export|genetic|graphics|hill_climbing|if|image|inspect|layout_forceatlas2|layout_yifanhu|let|light|loop|match|migrate|monitor|output|output_file|overlay|parameter|pause_sound|permanent|put|reactive_tabu|reflex|release|remove|resume_sound|return|run|save|save_batch|set|setup|simulate|solve|species|start_sound|state|status|stop_sound|switch|tabu|task|test|trace|transition|user_command|user_init|user_input|user_panel|using|Variable_container|Variable_number|Variable_regular|warn|write)\b/';
# list of type
$typePattern = '/\b(agent|bool|container|conversation|date|file|float|font|geometry|graph|int|list|map|matrix|message|pair|path|point|regression|rgb|skill|species|string|topology|unknown)\b/';
# list of operator
$operatorPattern = '/\b(abs|accumulate|acos|add_days|add_edge|add_hours|add_minutes|add_months|add_node|add_point|add_seconds|add_weeks|add_years|adjacency|agent|agent_closest_to|agent_farthest_to|agent_from_geometry|agents_at_distance|agents_inside|agents_overlapping|all_pairs_shortest_path|alpha_index|among|and|angle_between|any|any_location_in|any_point_in|append_horizontally|append_vertically|arc|around|as|as_4_grid|as_date|as_distance_graph|as_driving_graph|as_edge_graph|as_grid|as_hexagonal_grid|as_int|as_intersection_graph|as_map|as_matrix|as_path|as_system_date|as_system_time|as_time|asin|at|at_distance|at_location|atan|atan2|auto_correlation|beta|beta_index|between|betweenness_centrality|biggest_cliques_of|binomial|binomial_coeff|binomial_complemented|binomial_sum|blend|bool|box|brewer_colors|brewer_palettes|buffer|build|ceil|change_clockwise|char|chi_square|chi_square_complemented|circle|clean|closest_points_with|closest_to|clustering_cobweb|clustering_DBScan|clustering_em|clustering_farthestFirst|clustering_simple_kmeans|clustering_xmeans|collect|column_at|columns_list|command|cone|cone3D|connected_components_of|connectivity_index|container|contains|contains_all|contains_any|contains_edge|contains_vertex|conversation|convex_hull|copy|copy_between|corR|correlation|cos|cos_rad|count|covariance|covers|cross|crosses|crs|CRS_transform|csv_file|cube|curve|cylinder|date|dbscan|dead|degree_of|dem|det|determinant|diff|diff2|directed|direction_between|direction_to|disjoint_from|distance_between|distance_to|distribution_of|distribution2d_of|div|dnorm|durbin_watson|dxf_file|edge|edge_between|edges|eigenvalues|electre_DM|ellipse|empty|enlarged_by|envelope|eval_gaml|even|every|evidence_theory_DM|exp|fact|farthest_point_to|farthest_to|file|file_exists|first|first_with|flip|float|floor|folder|font|frequency_of|fuzzy_kappa|fuzzy_kappa_sim|gaml_file|gamma|gamma_distribution|gamma_distribution_complemented|gamma_index|gauss|generate_barabasi_albert|generate_complete_graph|generate_watts_strogatz|geometric_mean|geometry|geometry_collection|get|graph|grayscale|grid_at|grid_cells_to_graph|grid_file|group_by|harmonic_mean|hexagon|hierarchical_clustering|hsb|hypot|IDW|image_file|in|in_degree_of|in_edges_of|incomplete_beta|incomplete_gamma|incomplete_gamma_complement|indented_by|index_by|index_of|inside|int|inter|interleave|internal_at|internal_integrated_value|internal_zero_order_equation|intersection|intersects|inverse|inverse_distance_weighting|is|is_clockwise|is_csv|is_dxf|is_finite|is_gaml|is_grid|is_image|is_number|is_obj|is_osm|is_pgm|is_property|is_R|is_shape|is_skill|is_svg|is_text|is_threeds|is_URL|is_xml|kappa|kappa_sim|kmeans|kurtosis|last|last_index_of|last_with|layout|length|lgamma|line|link|list|list_with|ln|load_graph_from_file|load_shortest_paths|log|log_gamma|map|masked_by|matrix|matrix_with|max|max_of|maximal_cliques_of|mean|mean_deviation|mean_of|meanR|median|message|min|min_of|mod|moment|mul|nb_cycles|neighbors_at|neighbors_of|new_folder|node|nodes|norm|normal_area|normal_density|normal_inverse|not|obj_file|of|of_generic_species|of_species|one_of|or|osm_file|out_degree_of|out_edges_of|overlapping|overlaps|pair|partially_overlaps|path|path_between|path_to|paths_between|pbinom|pchisq|percent_absolute_deviation|percentile|pgamma|pgm_file|plan|pnorm|point|points_at|points_on|poisson|polygon|polyhedron|polyline|polyplan|predecessors_of|predict|product|product_of|promethee_DM|property_file|pValue_for_fStat|pValue_for_tStat|pyramid|quantile|quantile_inverse|R_correlation|R_file|R_mean|range|rank_interpolated|read|rectangle|reduced_by|regression|remove_duplicates|remove_node_from|replace|replace_regex|reverse|rewire_n|rgb|rgb_to_xyz|rms|rnd|rnd_choice|rnd_color|rotated_by|round|row_at|rows_list|sample|saveAgent|saveSimulation|scaled_by|scaled_to|select|serialize|serializeAgent|set_z|shape_file|shuffle|signum|simple_clustering_by_distance|simple_clustering_by_envelope_distance|simplification|sin|sin_rad|skeletonize|skew|skill|smooth|solid|sort|sort_by|source_of|spatial_graph|species|species_of|sphere|split_at|split_geometry|split_lines|split_with|sqrt|square|squircle|standard_deviation|string|student_area|student_t_inverse|subtract_days|subtract_hours|subtract_minutes|subtract_months|subtract_seconds|subtract_weeks|subtract_years|successors_of|sum|sum_of|svg_file|tan|tan_rad|tanh|target_of|teapot|text_file|TGauss|threeds_file|to|to_GAMA_CRS|to_gaml|to_rectangles|to_squares|to_triangles|tokenize|topology|touches|towards|trace|transformed_by|translated_by|translated_to|transpose|triangle|triangulate|truncated_gauss|undirected|union|unknown|unserialize|unSerializeSimulation|URL_file|use_cache|user_input|using|variance|variance|variance_of|voronoi|weight_of|weighted_means_DM|where|with_max_of|with_min_of|with_optimizer_type|with_precision|with_weights|without_holes|writable|xml_file)\b/';
# list of facet
$facetPattern = '/\b(left|right|name|type|of|index|virtual|to|item|edge|vertex|node|at|all|weight|value|trace|selectable|fading|position|size|transparency|name|focus|aspect|refresh|name|temp_end|temp_decrease|temp_init|nb_iter_cst_temp|maximize|minimize|aggregation|target|as|name|value|equals|is_not|raises|name|location|look_at|up_vector|target|as|returns|x_range|y_range|position|size|reverse_axes|background|x_serie|x_serie_labels|y_serie_labels|axes|type|style|gap|y_tick_unit|x_tick_unit|name|x_label|y_label|color|series_label_position|tick_font|tick_font_size|tick_font_style|label_font|label_font_size|label_font_style|legend_font|legend_font_size|legend_font_style|title_font|title_font_size|title_font_style|species|returns|from|number|as|with|header|value|legend|y_err_values|x_err_values|y_minmax_values|marker_size|color|accumulate_values|line_visible|marker|marker_shape|fill|style|value|y_err_values|x_err_values|y_minmax_values|marker_size|legend|marker|marker_shape|accumulate_values|line_visible|fill|color|style|value|var|on|mat_diffu|matrix|method|min_value|mask|proportion|propagation|radius|variation|cycle_length|avoid_mask|background|name|focus|type|refresh_every|refresh|fullscreen|tesselation|z_fighting|trace|scale|show_fps|draw_env|orthographic_projection|ambient_light|diffuse_light|diffuse_light_pos|light|draw_diffuse_light|camera_pos|camera_look_pos|camera_up_vector|camera_interaction|polygonmode|autosave|output3D|position|selectable|size|transparency|species|lines|elevation|texture|grayscale|triangulation|text|draw_as_dem|dem|refresh|position|selectable|size|transparency|trace|fading|species|aspect|refresh|action|with|internal_function|returns|geometry|texture|empty|border|rounded|at|size|color|rotate|font|depth|begin_arrow|end_arrow|perspective|bitmap|name|type|vars|params|simultaneously|message|unused|name|action|mouse_location|selected_agents|name|maximize|minimize|aggregation|name|title|parent|skills|control|frequency|schedules|keep_seed|repeat|until|multicore|type|name|var|framerate|name|pop_dim|crossover_prob|mutation_prob|nb_prelim_gen|max_gen|maximize|minimize|aggregation|position|trace|fading|size|transparency|name|refresh|name|iter_max|maximize|minimize|aggregation|condition|file|position|size|transparency|name|gis|color|refresh|name|refresh_every|refresh|value|attributes|type|graph|nb_steps|thread_number|dissuade_hubs|linlog_mode|prevent_overlap|edge_weight_influence|scaling|stronger_gravity|gravity|tolerance|approximate_repulsion|approximation|bounded_point1|bounded_point2|graph|optimal_distance|quadtree_max_level|theta|relative_strength|step_size|nb_steps|bounded_point1|bounded_point2|name|value|of|index|type|id|position|type|direction|spot_angle|linear_attenuation|quadratic_attenuation|active|color|draw_light|update|from|to|step|name|over|while|times|value|source|target|returns|name|refresh_every|color|refresh|value|name|data|refresh_every|refresh|header|footer|rewrite|type|rounded|border|position|size|transparency|left|right|center|background|color|name|type|init|min|max|category|var|unit|step|among|at|key|all|item|edge|weight|in|name|iter_max|tabu_list_size_init|tabu_list_size_max|tabu_list_size_min|nb_tests_wthout_col_max|cycle_size_max|cycle_size_min|maximize|minimize|aggregation|when|name|target|as|in|returns|item|from|index|edge|vertex|node|key|all|value|of|name|end_cycle|core|seed|with_output|with_param|type|data|rewrite|header|to|crs|with|to|rewrite|data|name|value|comodel|with_experiment|share|with_input|with_output|reset|until|repeat|equation|method|integrated_times|integrated_values|discretizing_step|time_initial|time_final|cycle_length|step|min_step|max_step|scalAbsoluteTolerance|scalRelativeTolerance|width|height|cell_width|cell_height|neighbours|neighbors|use_individual_shapes|use_regular_agents|use_neighbors_cache|file|torus|name|parent|edge_species|skills|mirrors|control|compile|frequency|schedules|topology|source|mode|repeat|initial|final|name|color|message|value|name|iter_max|tabu_list_size|maximize|minimize|aggregation|weight|name|name|when|to|continue|color|action|name|when|with|initial|name|name|type|init|min|max|returns|among|initial|name|topology|name|type|init|value|update|function|const|category|parameter|size|of|index|fill_with|name|type|init|value|update|function|const|category|parameter|min|max|step|among|name|type|of|index|init|value|update|function|const|category|parameter|among|message|color|message)\b\:/';
# list of literal
$literalPattern = '/\b(true|false|unknown|nil)\b/';
    # end of the automatically generated part

    $codeblock = preg_replace_callback($statementPattern, array($this, '_addStatement_callback'), $codeblock);
    $codeblock = preg_replace_callback($operatorPattern, array($this, '_addOperator_callback'), $codeblock);
    $codeblock = preg_replace_callback($literalPattern, array($this, '_addLiteral_callback'), $codeblock);
    $codeblock = preg_replace_callback($typePattern, array($this, '_addType_callback'), $codeblock);
    $codeblock = preg_replace_callback($facetPattern, array($this, '_addFacet_callback'), $codeblock);

    # find string
    $codeblock = preg_replace_callback('(".*?")', array($this, '_addString_callback'), $codeblock);
    # find comments 
    $codeblock = preg_replace_callback('(/\*[\s\S]+\*/|\/\/.*?\n)', array($this, '_addComment_callback'), $codeblock);
    # find constants and pseudo variable
    $codeblock = preg_replace_callback('(\#\w+|each|self|myself|nil)', array($this, '_addConstantAndPseudoVariable_callback'), $codeblock);
    # find variables
    #$codeblock = preg_replace_callback('([^\#|\>]\b(\w+)\b)', array($this, '_addVariable_callback'), $codeblock);

    $codeblock = preg_replace_callback('/^\n+/',
        array($this, '_doFencedCodeBlocks_newlines'), $codeblock);

    $classes = array();
    if ($classname != "") {
      if ($classname{0} == '.')
        $classname = substr($classname, 1);
      $classes[] = $this->code_class_prefix . $classname;
    }
    $attr_str = $this->doExtraAttributes($this->code_attr_on_pre ? "pre" : "code", $attrs, null, $classes);
    $pre_attr_str  = $this->code_attr_on_pre ? $attr_str : '';
    $code_attr_str = $this->code_attr_on_pre ? '' : $attr_str;
    $codeblock  = "<pre$pre_attr_str><code$code_attr_str>$codeblock</code></pre>";

    return "\n\n".$this->hashBlock($codeblock)."\n\n";
  }

  protected function _addComment_callback($matches) {
    return '<comment>'.$matches[0].'</comment>';
  }

  protected function _addStatement_callback($matches) {
    return '<statement>'.$matches[0].'</statement>';
  }

  protected function _addOperator_callback($matches) {
    return '<operator>'.$matches[0].'</operator>';
  }

  protected function _addFacet_callback($matches) {
    return '<facet>'.$matches[0].'</facet>';
  }

  protected function _addString_callback($matches) {
    return '<string>'.$matches[0].'</string>';
  }

  protected function _addLiteral_callback($matches) {
    return '<literal>'.$matches[0].'</literal>';
  }

  protected function _addType_callback($matches) {
    return '<type>'.$matches[0].'</type>';
  }

  protected function _addSpecialChar_callback($matches) {
    return '<special_char>'.$matches[0].'</special_char>';
  }

  protected function _addConstantAndPseudoVariable_callback($matches) {
    return '<constant>'.$matches[0].'</constant>';
  }

  protected function _addVariable_callback($matches) {
    return '<variable>'.$matches[0].'</variable>';
  }

  /**
   * Replace new lines in fenced code blocks
   * @param  array $matches
   * @return string
   */
  protected function _doFencedCodeBlocks_newlines($matches) {
    return str_repeat("<br$this->empty_element_suffix",
        strlen($matches[0]));
  }

  /**
   * Redefining emphasis markers so that emphasis by underscore does not
   * work in the middle of a word.
   * @var array
   */
  protected $em_relist = array(
      ''  => '(?:(?<!\*)\*(?!\*)|(?<![a-zA-Z0-9_])_(?!_))(?![\.,:;]?\s)',
      '*' => '(?<![\s*])\*(?!\*)',
      '_' => '(?<![\s_])_(?![a-zA-Z0-9_])',
  );
  protected $strong_relist = array(
      ''   => '(?:(?<!\*)\*\*(?!\*)|(?<![a-zA-Z0-9_])__(?!_))(?![\.,:;]?\s)',
      '**' => '(?<![\s*])\*\*(?!\*)',
      '__' => '(?<![\s_])__(?![a-zA-Z0-9_])',
  );
  protected $em_strong_relist = array(
      ''    => '(?:(?<!\*)\*\*\*(?!\*)|(?<![a-zA-Z0-9_])___(?!_))(?![\.,:;]?\s)',
      '***' => '(?<![\s*])\*\*\*(?!\*)',
      '___' => '(?<![\s_])___(?![a-zA-Z0-9_])',
  );

  /**
   * Parse text into paragraphs
   * @param  string $text String to process with html <p> tags
   * @return string       HTML output
   */
  protected function formParagraphs($text) {
    // Strip leading and trailing lines:
    $text = preg_replace('/\A\n+|\n+\z/', '', $text);

    $grafs = preg_split('/\n{2,}/', $text, -1, PREG_SPLIT_NO_EMPTY);

    // Wrap <p> tags and unhashify HTML blocks
    foreach ($grafs as $key => $value) {
      $value = trim($this->runSpanGamut($value));

      // Check if this should be enclosed in a paragraph.
      // Clean tag hashes & block tag hashes are left alone.
      $is_p = !preg_match('/^B\x1A[0-9]+B|^C\x1A[0-9]+C$/', $value);

      if ($is_p) {
        $value = "<p>$value</p>";
      }
      $grafs[$key] = $value;
    }

    // Join grafs in one text, then unhash HTML tags.
    $text = implode("\n\n", $grafs);

    // Finish by removing any tag hashes still present in $text.
    $text = $this->unhash($text);

    return $text;
  }


  /**
   * Footnotes - Strips link definitions from text, stores the URLs and
   * titles in hash references.
   * @param  string $text
   * @return string
   */
  protected function stripFootnotes($text) {
    $less_than_tab = $this->tab_width - 1;

    // Link defs are in the form: [^id]: url "optional title"
    $text = preg_replace_callback('{
      ^[ ]{0,' . $less_than_tab . '}\[\^(.+?)\][ ]?:  # note_id = $1
        [ ]*
        \n?         # maybe *one* newline
      (           # text = $2 (no blank lines allowed)
        (?:         
          .+        # actual text
        |
          \n        # newlines but 
          (?!\[.+?\][ ]?:\s)# negative lookahead for footnote or link definition marker.
          (?!\n+[ ]{0,3}\S)# ensure line is not blank and followed 
                  # by non-indented content
        )*
      )   
      }xm',
        array($this, '_stripFootnotes_callback'),
        $text);
    return $text;
  }

  /**
   * Callback for stripping footnotes
   * @param  array $matches
   * @return string
   */
  protected function _stripFootnotes_callback($matches) {
    $note_id = $this->fn_id_prefix . $matches[1];
    $this->footnotes[$note_id] = $this->outdent($matches[2]);
    return ''; // String that will replace the block
  }

  /**
   * Replace footnote references in $text [^id] with a special text-token
   * which will be replaced by the actual footnote marker in appendFootnotes.
   * @param  string $text
   * @return string
   */
  protected function doFootnotes($text) {
    if (!$this->in_anchor) {
      $text = preg_replace('{\[\^(.+?)\]}', "F\x1Afn:\\1\x1A:", $text);
    }
    return $text;
  }

  /**
   * Append footnote list to text
   * @param  string $text
   * @return string
   */
  protected function appendFootnotes($text) {
    $text = preg_replace_callback('{F\x1Afn:(.*?)\x1A:}',
        array($this, '_appendFootnotes_callback'), $text);

    if (!empty($this->footnotes_ordered)) {
      $text .= "\n\n";
      $text .= "<div class=\"footnotes\">\n";
      $text .= "<hr" . $this->empty_element_suffix . "\n";
      $text .= "<ol>\n\n";

      $attr = "";
      if ($this->fn_backlink_class != "") {
        $class = $this->fn_backlink_class;
        $class = $this->encodeAttribute($class);
        $attr .= " class=\"$class\"";
      }
      if ($this->fn_backlink_title != "") {
        $title = $this->fn_backlink_title;
        $title = $this->encodeAttribute($title);
        $attr .= " title=\"$title\"";
      }
      $backlink_text = $this->fn_backlink_html;
      $num = 0;

      while (!empty($this->footnotes_ordered)) {
        $footnote = reset($this->footnotes_ordered);
        $note_id = key($this->footnotes_ordered);
        unset($this->footnotes_ordered[$note_id]);
        $ref_count = $this->footnotes_ref_count[$note_id];
        unset($this->footnotes_ref_count[$note_id]);
        unset($this->footnotes[$note_id]);

        $footnote .= "\n"; // Need to append newline before parsing.
        $footnote = $this->runBlockGamut("$footnote\n");
        $footnote = preg_replace_callback('{F\x1Afn:(.*?)\x1A:}',
            array($this, '_appendFootnotes_callback'), $footnote);

        $attr = str_replace("%%", ++$num, $attr);
        $note_id = $this->encodeAttribute($note_id);

        // Prepare backlink, multiple backlinks if multiple references
        $backlink = "<a href=\"#fnref:$note_id\"$attr>$backlink_text</a>";
        for ($ref_num = 2; $ref_num <= $ref_count; ++$ref_num) {
          $backlink .= " <a href=\"#fnref$ref_num:$note_id\"$attr>$backlink_text</a>";
        }
        // Add backlink to last paragraph; create new paragraph if needed.
        if (preg_match('{</p>$}', $footnote)) {
          $footnote = substr($footnote, 0, -4) . "&#160;$backlink</p>";
        } else {
          $footnote .= "\n\n<p>$backlink</p>";
        }

        $text .= "<li id=\"fn:$note_id\">\n";
        $text .= $footnote . "\n";
        $text .= "</li>\n\n";
      }

      $text .= "</ol>\n";
      $text .= "</div>";
    }
    return $text;
  }

  /**
   * Callback for appending footnotes
   * @param  array $matches
   * @return string
   */
  protected function _appendFootnotes_callback($matches) {
    $node_id = $this->fn_id_prefix . $matches[1];

    // Create footnote marker only if it has a corresponding footnote *and*
    // the footnote hasn't been used by another marker.
    if (isset($this->footnotes[$node_id])) {
      $num =& $this->footnotes_numbers[$node_id];
      if (!isset($num)) {
        // Transfer footnote content to the ordered list and give it its
        // number
        $this->footnotes_ordered[$node_id] = $this->footnotes[$node_id];
        $this->footnotes_ref_count[$node_id] = 1;
        $num = $this->footnote_counter++;
        $ref_count_mark = '';
      } else {
        $ref_count_mark = $this->footnotes_ref_count[$node_id] += 1;
      }

      $attr = "";
      if ($this->fn_link_class != "") {
        $class = $this->fn_link_class;
        $class = $this->encodeAttribute($class);
        $attr .= " class=\"$class\"";
      }
      if ($this->fn_link_title != "") {
        $title = $this->fn_link_title;
        $title = $this->encodeAttribute($title);
        $attr .= " title=\"$title\"";
      }

      $attr = str_replace("%%", $num, $attr);
      $node_id = $this->encodeAttribute($node_id);

      return
          "<sup id=\"fnref$ref_count_mark:$node_id\">".
          "<a href=\"#fn:$node_id\"$attr>$num</a>".
          "</sup>";
    }

    return "[^" . $matches[1] . "]";
  }


  /**
   * Abbreviations - strips abbreviations from text, stores titles in hash
   * references.
   * @param  string $text
   * @return string
   */
  protected function stripAbbreviations($text) {
    $less_than_tab = $this->tab_width - 1;

    // Link defs are in the form: [id]*: url "optional title"
    $text = preg_replace_callback('{
      ^[ ]{0,' . $less_than_tab . '}\*\[(.+?)\][ ]?:  # abbr_id = $1
      (.*)          # text = $2 (no blank lines allowed)  
      }xm',
        array($this, '_stripAbbreviations_callback'),
        $text);
    return $text;
  }

  /**
   * Callback for stripping abbreviations
   * @param  array $matches
   * @return string
   */
  protected function _stripAbbreviations_callback($matches) {
    $abbr_word = $matches[1];
    $abbr_desc = $matches[2];
    if ($this->abbr_word_re) {
      $this->abbr_word_re .= '|';
    }
    $this->abbr_word_re .= preg_quote($abbr_word);
    $this->abbr_desciptions[$abbr_word] = trim($abbr_desc);
    return ''; // String that will replace the block
  }

  /**
   * Find defined abbreviations in text and wrap them in <abbr> elements.
   * @param  string $text
   * @return string
   */
  protected function doAbbreviations($text) {
    if ($this->abbr_word_re) {
      // cannot use the /x modifier because abbr_word_re may
      // contain significant spaces:
      $text = preg_replace_callback('{' .
          '(?<![\w\x1A])' .
          '(?:' . $this->abbr_word_re . ')' .
          '(?![\w\x1A])' .
          '}',
          array($this, '_doAbbreviations_callback'), $text);
    }
    return $text;
  }

  /**
   * Callback for processing abbreviations
   * @param  array $matches
   * @return string
   */
  protected function _doAbbreviations_callback($matches) {
    $abbr = $matches[0];
    if (isset($this->abbr_desciptions[$abbr])) {
      $desc = $this->abbr_desciptions[$abbr];
      if (empty($desc)) {
        return $this->hashPart("<abbr>$abbr</abbr>");
      } else {
        $desc = $this->encodeAttribute($desc);
        return $this->hashPart("<abbr title=\"$desc\">$abbr</abbr>");
      }
    } else {
      return $matches[0];
    }
  }
}
