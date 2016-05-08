package com.sumarnakreatip.uiiot;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.HttpClient;
import org.apache.http.client.ResponseHandler;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.BasicResponseHandler;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class Kontak extends Activity {

    //variabel layout
    Button b, c;
    EditText nomor, email;
    String regid, user;

    //variabel koneksi
    HttpPost httppost;
    StringBuffer buffer;
    HttpResponse response;
    HttpClient httpclient;
    List<NameValuePair> nameValuePairs;
    ProgressDialog dialog = null;

    private Pattern pattern;
    private Matcher matcher;

    private static final String EMAIL_PATTERN =
            "^[_A-Za-z0-9-\\+]+(\\.[_A-Za-z0-9-]+)*@"
                    + "[A-Za-z0-9-]+(\\.[A-Za-z0-9]+)*(\\.[A-Za-z]{2,})$";

    private String noHP, inputEmail;

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.kontak);

        pattern = Pattern.compile(EMAIL_PATTERN);

        //inisialisasi variabel
        user = getIntent().getExtras().getString("username");
        b = (Button) findViewById(R.id.button1);
        nomor = (EditText) findViewById(R.id.nomor);
        email = (EditText) findViewById(R.id.email);

        b.setOnClickListener(new OnClickListener() {
            @Override
            public void onClick(View v) {
                inputEmail = email.getText().toString();
                noHP = email.getText().toString();

                try{
                    if(validate(inputEmail) && !noHP.isEmpty()){
                        dialog = ProgressDialog.show(Kontak.this, "",
                                "Processing...", true);
                        new Thread(new Runnable() {
                            public void run() {
                                masukkan();
                            }
                        }).start();
                    }
                    else{
                        Toast.makeText(Kontak.this, "Salah Input Nomor HP/Email!",Toast.LENGTH_SHORT).show();
                    }
                }
                catch (Exception e){
                    Toast.makeText(Kontak.this, "Cek Input Anda!",Toast.LENGTH_SHORT).show();
                }
            }
        });

    }

    //method tuk masukkan data ke profil
    void masukkan() {
        try {
            httpclient = new DefaultHttpClient();
            httppost = new HttpPost("http://green.ui.ac.id/nebeng/back-system/update_user_data.php");
            //add your data
            nameValuePairs = new ArrayList<NameValuePair>(2);
            // Always use the same variable name for posting i.e the android side variable name and php side variable name should be <span id="IL_AD8" class="IL_AD">similar</span>, 
            nameValuePairs.add(new BasicNameValuePair("username", user));
            nameValuePairs.add(new BasicNameValuePair("nomor", noHP.trim()));
            nameValuePairs.add(new BasicNameValuePair("email", inputEmail.trim()));
            httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));
            //Execute HTTP Post Request
            ResponseHandler<String> responseHandler = new BasicResponseHandler();
            String response = httpclient.execute(httppost, responseHandler);
            String httpResponse = httpclient.execute(httppost, responseHandler).trim();
            JSONObject jsonObject = new JSONObject(httpResponse);
            if (jsonObject.has("result")) {
                response = jsonObject.optString("result");
            }
            runOnUiThread(new Runnable() {
                public void run() {

                    dialog.dismiss();
                }
            });

            //cek apakah data sudah berhasil dimasukkan atau belum
            if (response.equalsIgnoreCase("Sukses")) {
                runOnUiThread(new Runnable() {
                    public void run() {
                        Toast.makeText(Kontak.this, "Data sukses dimasukkan", Toast.LENGTH_LONG).show();
                    }
                });
                SaveSharedPreference.setUserName(Kontak.this, user.toString().trim());
                Intent datalogin = new Intent(Kontak.this, Home.class);
                startActivity(datalogin);
                finish();
            } else {
                runOnUiThread(new Runnable() {
                    public void run() {
                        Toast.makeText(Kontak.this, "Data tidak berhasil dimasukkan, coba ulang", Toast.LENGTH_SHORT).show();
                    }
                });
            }

        } catch (Exception e) {
            dialog.dismiss();
            Toast.makeText(Kontak.this, "Exception : " + e.getMessage(), Toast.LENGTH_LONG).show();
        }
    }

    public void onDestroy() {
        super.onDestroy();
    }

    public boolean validate(final String hex) {
        matcher = pattern.matcher(hex);
        return matcher.matches();
    }
}