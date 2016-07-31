package gamaws.utils;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.IOException;
import java.io.PrintWriter;
import java.io.UnsupportedEncodingException;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.Scanner;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class DBConnection {
	private Connection connect = null;
	private PreparedStatement preparedStatement = null;
	private ResultSet resultSet = null;
	
	public static final String databaseIDFileName = "databaseID.txt";
	private static final String DB_DRIVER = "com.mysql.jdbc.Driver";
	private static String DB_CONNECTION = "jdbc:mysql://localhost:3306/gamaws?useSSL=false"; // this is the default value, can be changed in the file "databaseID.txt"
	private static String DB_DELIMITER = "db:";
	private static String DB_USER = null;
	private static String USR_DELIMITER = "user:";
	private static String DB_PASSWORD = null;
	private static String PSW_DELIMITER = "pwd:";
	
	private static Connection getDBConnection() {
		Connection dbConnection = null;
		// find database id (user and password)
		try {
			if (!loadDatabaseIDs(databaseIDFileName)) {
				System.exit(-1);
			}
		} catch (FileNotFoundException e1) {
			// TODO Auto-generated catch block
			e1.printStackTrace();
		}
		
		try {
			Class.forName(DB_DRIVER);
		} catch (ClassNotFoundException e) {
			System.out.println(e.getMessage());
		}
		try {
			dbConnection = DriverManager.getConnection(DB_CONNECTION, DB_USER, DB_PASSWORD);
			return dbConnection;

		} catch (SQLException e) {
			System.out.println(e.getMessage());
		}
		return dbConnection;

	}
	
	private static boolean loadDatabaseIDs(String fileName) throws FileNotFoundException {
		
		boolean result = false;
		Path relativePath = Paths.get(fileName);
		String relativePathString = relativePath.toAbsolutePath().toString();
		File f = new File(relativePathString);
		if (!f.exists()) {
			f.getParentFile().mkdirs();
			try {
				f.createNewFile();
			} catch (IOException e) {
				e.printStackTrace();
			}
			// write the default values
			PrintWriter writer;
			try {
				writer = new PrintWriter(f.getAbsolutePath(), "UTF-8");
				writer.println(USR_DELIMITER);
				writer.println(PSW_DELIMITER);
				writer.println(DB_DELIMITER+DB_CONNECTION);
				writer.close();
			} catch (UnsupportedEncodingException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
			
			System.out.println("The file " + f.getAbsolutePath() + " has been created.");
		}

		Scanner scanner = new Scanner(f);
		BufferedReader br = new BufferedReader(new FileReader(f.getAbsolutePath()));
		String line;
		String pattern = "((?!\\s).)*"; // find all the character groups which are not whitespace
		Pattern r = Pattern.compile(pattern);
		try {
			while ((line = br.readLine()) != null) {
				if (line.contains(USR_DELIMITER)) {
					if (line.split(USR_DELIMITER).length > 0) {
						String newLine = line.split(USR_DELIMITER)[1];
						Matcher m = r.matcher(newLine);
						if (m.find( )) {
							DB_USER = m.group(0);
						}
					}
				}
				if (line.contains(PSW_DELIMITER)) {
					if (line.split(PSW_DELIMITER).length > 0) {
						String newLine = line.split(PSW_DELIMITER)[1];
						Matcher m = r.matcher(newLine);
						if (m.find( )) {
							DB_PASSWORD = m.group(0);
						}
					}
				}
				if (line.contains(DB_DELIMITER)) {
					if (line.split(DB_DELIMITER).length > 0) {
						String newLine = line.split(DB_DELIMITER)[1];
						Matcher m = r.matcher(newLine);
						if (m.find( )) {
							DB_CONNECTION = DB_CONNECTION.replace("/gamaws?", "/" + m.group(0) + "?");
						}
					}
				}
			}
			br.close();
		} catch (IOException e) {
			e.printStackTrace();
		}

		if (DB_USER != null && DB_PASSWORD != null && DB_USER != "" && DB_PASSWORD != "") {
			result = true;
		}
		
		String outputMsg = (result) ? "Database IDs loaded correctly."
				: "Problem with loading the database IDs from the \"databaseID.txt\" file."
						+ " Please respect the following syntax : \nuser:[here the user name]\npwd:[here the passeword]\ndb:[here the name of the database]";
		System.out.println(outputMsg);
		scanner.close();
		return result;
	}
	
	// You need to close the resultSet
	public void connect() {
		connect = DBConnection.getDBConnection();
	}

	// You need to close the resultSet
	public void close() {
		try {
			if (resultSet != null) {
				resultSet.close();
			}

			if (preparedStatement != null) {
				preparedStatement.close();
			}

			if (connect != null) {
				connect.close();
			}
		} catch (Exception e) {
			e.printStackTrace();
		}
	}
	
	public boolean prepareStatement(String query){
		try {
			preparedStatement = connect.prepareStatement(query);
			return true;
		} catch (SQLException e) {
			e.printStackTrace();
			return false;
		}
	}
	
	public static void resetAutoIncrement(String dbname, int autoIncrement) {
		DBConnection dbc = new DBConnection();
		dbc.connect();
		try {
			if(dbc.prepareStatement("ALTER TABLE " + dbname + " AUTO_INCREMENT = " + autoIncrement + " ;")){
				dbc.getPreparedStatement().executeUpdate();
				System.out.println("reset AUTO_INCREMENT");
			}
		} catch (Exception e) {
			e.printStackTrace();
		} finally {
			dbc.close();
		}
	}
	
	public Connection getConnect() {
		return connect;
	}


	public void setConnect(Connection connect) {
		this.connect = connect;
	}


	public PreparedStatement getPreparedStatement() {
		return preparedStatement;
	}


	public void setPreparedStatement(PreparedStatement preparedStatement) {
		this.preparedStatement = preparedStatement;
	}


	public ResultSet getResultSet() {
		return resultSet;
	}


	public void setResultSet(ResultSet resultSet) {
		this.resultSet = resultSet;
	}

}
