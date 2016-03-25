package com.directions.route;

import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.OutputStream;

import android.os.Environment;
import android.util.Log;

public class Writelong {

	private static String namafile;
	private static File dir = Environment.getExternalStoragePublicDirectory(Environment.DIRECTORY_DCIM);
	private static String yangditulis;
	private File files;
	public Writelong(String nama){
		this(dir,nama);
	}
	public Writelong(File dir, String nama){
		this.dir=dir;
		namafile=nama;
		yangditulis="";
	}
	public void writeSesuatu(String tambahan){
		yangditulis+=tambahan;
	}
	public void selesai(){
		files = new File(dir,namafile);		
		dir.mkdirs();	
			try {
				OutputStream os = new FileOutputStream(files);
				for(int count=0;yangditulis.length()>count;count++){
					os.write((int)yangditulis.charAt(count));
				}
				os.close();				
			} catch (FileNotFoundException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			} catch (Exception e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
		
			
			
			}
		}
}
