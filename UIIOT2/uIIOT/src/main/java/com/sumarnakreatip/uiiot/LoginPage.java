package com.sumarnakreatip.uiiot;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Intent;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.google.android.gms.appindexing.Action;
import com.google.android.gms.appindexing.AppIndex;
import com.google.android.gms.common.api.GoogleApiClient;

import org.apache.http.NameValuePair;
import org.apache.http.client.HttpClient;
import org.apache.http.client.ResponseHandler;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.BasicResponseHandler;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONObject;

import java.net.MalformedURLException;
import java.util.ArrayList;
import java.util.List;

public class LoginPage extends Activity {

    //variabel layout
    Button b, c;
    EditText et, pass;

    String id = "";
    String npm = "";
    String username = "";
    String nama="";
    String role="";

    //variabel koneksi
    HttpPost httppost;
    StringBuffer buffer;
    HttpClient httpclient;
    List<NameValuePair> nameValuePairs;
    ProgressDialog dialog = null;
    String regid, response;
    /**
     * ATTENTION: This was auto-generated to implement the App Indexing API.
     * See https://g.co/AppIndexing/AndroidStudio for more information.
     */
    private GoogleApiClient client;

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.login);

        b = (Button) findViewById(R.id.button1);
        et = (EditText) findViewById(R.id.username);
        pass = (EditText) findViewById(R.id.password);
        b.setOnClickListener(new OnClickListener() {
            @Override
            public void onClick(View v) {
                dialog = ProgressDialog.show(LoginPage.this, "",
                        "Processing...", true);
                new Thread(new Runnable() {
                    public void run() {
                        login();
                    }
                }).start();
            }
        });

        // ATTENTION: This was auto-generated to implement the App Indexing API.
        // See https://g.co/AppIndexing/AndroidStudio for more information.
        client = new GoogleApiClient.Builder(this).addApi(AppIndex.API).build();
    }

    //method tuk cek ke sso
    void login() {
        try {
            httpclient = new DefaultHttpClient();
            httppost = new HttpPost("http://green.ui.ac.id/nebeng/back-system/check_user_login.php");
            //add your data
            nameValuePairs = new ArrayList<NameValuePair>(2);
            // Always use the same variable name for posting i.e the android side variable name and php side variable name should be <span id="IL_AD8" class="IL_AD">similar</span>, 
            nameValuePairs.add(new BasicNameValuePair("username", et.getText().toString().trim()));
            nameValuePairs.add(new BasicNameValuePair("password", pass.getText().toString().trim()));
            httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));
            //Execute HTTP Post Request
            ResponseHandler<String> responseHandler = new BasicResponseHandler();
            final String httpResponse = httpclient.execute(httppost, responseHandler).trim();
            JSONObject jsonObject = new JSONObject(httpResponse);
            Log.i("JsonRespon", httpResponse);
            if (jsonObject.has("result")) {
                response = jsonObject.getString("result");
            }
            if (jsonObject.has("id")) {
                id = jsonObject.getString("id");
                SaveSharedPreference.setUserID(LoginPage.this, id.toString().trim());
            }
            if (jsonObject.has("npm")) {
                npm = jsonObject.getString("npm");
                SaveSharedPreference.setNpm(LoginPage.this, npm.toString().trim());
            }
            if (jsonObject.has("username")) {
                username = jsonObject.getString("username");
                SaveSharedPreference.setUserName(LoginPage.this, username.toString().trim());
            }
            if (jsonObject.has("role")) {
                role = jsonObject.getString("role");
                SaveSharedPreference.setRole(LoginPage.this, role.toString().trim());
            }
            if (jsonObject.has("nama")) {
                nama = jsonObject.getString("nama");
                SaveSharedPreference.setNama(LoginPage.this, nama.toString().trim());
            }

            //dialog.dismiss();
            runOnUiThread(new Runnable() {
                public void run() {
                    dialog.dismiss();
                }
            });

            //cek apakah mahasiswa aktif atau tidak
            if (response.equalsIgnoreCase("User Found")) {
                runOnUiThread(new Runnable() {
                    public void run() {
                        Toast.makeText(LoginPage.this, "Login Sukses", Toast.LENGTH_LONG).show();
                    }
                });
                Intent datalogin = new Intent(LoginPage.this, Home.class);
                datalogin.putExtra("username", et.getText().toString().trim());
                startActivity(datalogin);
                finish();
            } else if (response.equalsIgnoreCase("User New")) {
                runOnUiThread(new Runnable() {
                    public void run() {
                        Toast.makeText(LoginPage.this, "Login Sukses", Toast.LENGTH_LONG).show();
                    }
                });
                Intent datalogin = new Intent(LoginPage.this, Kontak.class);
                datalogin.putExtra("username", et.getText().toString().trim());
                startActivity(datalogin);
                finish();
            } else {
                runOnUiThread(new Runnable() {
                    public void run() {
                        Toast.makeText(LoginPage.this, "Login Tidak berhasil, Cek username dan password anda", Toast.LENGTH_SHORT).show();
                    }
                });
            }

        } catch (Exception e) {
            dialog.dismiss();
            Toast.makeText(LoginPage.this, "Exception : " + e.getMessage(), Toast.LENGTH_LONG).show();
        }
    }

    public void onDestroy() {
        super.onDestroy();
    }

    @Override
    public void onStart() {
        super.onStart();

        // ATTENTION: This was auto-generated to implement the App Indexing API.
        // See https://g.co/AppIndexing/AndroidStudio for more information.
        client.connect();
        Action viewAction = Action.newAction(
                Action.TYPE_VIEW, // TODO: choose an action type.
                "LoginPage Page", // TODO: Define a title for the content shown.
                // TODO: If you have web page content that matches this app activity's content,
                // make sure this auto-generated web page URL is correct.
                // Otherwise, set the URL to null.
                Uri.parse("http://host/path"),
                // TODO: Make sure this auto-generated app deep link URI is correct.
                Uri.parse("android-app://com.sumarnakreatip.uiiot/http/host/path")
        );
        AppIndex.AppIndexApi.start(client, viewAction);
    }

    @Override
    public void onStop() {
        super.onStop();

        // ATTENTION: This was auto-generated to implement the App Indexing API.
        // See https://g.co/AppIndexing/AndroidStudio for more information.
        Action viewAction = Action.newAction(
                Action.TYPE_VIEW, // TODO: choose an action type.
                "LoginPage Page", // TODO: Define a title for the content shown.
                // TODO: If you have web page content that matches this app activity's content,
                // make sure this auto-generated web page URL is correct.
                // Otherwise, set the URL to null.
                Uri.parse("http://host/path"),
                // TODO: Make sure this auto-generated app deep link URI is correct.
                Uri.parse("android-app://com.sumarnakreatip.uiiot/http/host/path")
        );
        AppIndex.AppIndexApi.end(client, viewAction);
        client.disconnect();
    }
}