package gamaws.utils;

import java.awt.Menu;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class DBConnection {
	private Connection connect = null;
	private PreparedStatement preparedStatement = null;
	private ResultSet resultSet = null;
	
	private static final String DB_DRIVER = "com.mysql.jdbc.Driver";
	private static final String DB_CONNECTION = "jdbc:mysql://localhost:3306/gamawsdev?useSSL=false";
	private static final String DB_USER = "root";
	private static final String DB_PASSWORD = "sworm4pass";
	
	private static Connection getDBConnection() {
		Connection dbConnection = null;
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
