package com.sumarnakreatip.uiiot;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.net.Uri;
import android.os.Bundle;
import android.os.Handler;
import android.view.Window;
import android.widget.ProgressBar;

import com.google.android.gms.appindexing.Action;
import com.google.android.gms.appindexing.AppIndex;
import com.google.android.gms.common.api.GoogleApiClient;

import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpPost;

import java.util.List;

public class MainActivity extends Activity {

    //Variabel koneksi
    HttpPost httppost;
    StringBuffer buffer;
    HttpResponse response;
    HttpClient httpclient;
    List<NameValuePair> nameValuePairs;
    ProgressDialog dialog = null;
    private String respon;

    private ProgressBar mProgress;
    private int mProgressStatus = 0;

    Context context;

    //control handler   
    private Handler mHandler = new Handler();
    /**
     * ATTENTION: This was auto-generated to implement the App Indexing API.
     * See https://g.co/AppIndexing/AndroidStudio for more information.
     */
    private GoogleApiClient client;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        requestWindowFeature(Window.FEATURE_NO_TITLE);
        //getWindow().setFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN,
                //WindowManager.LayoutParams.FLAG_FULLSCREEN);

        setContentView(R.layout.activity_main);

        //xml progress bar
        mProgress = (ProgressBar) findViewById(R.id.progress);
        context = getApplicationContext();

        // Start lengthy operation in a background thread
        //pengecekan login
        new Thread(new Runnable() {
            public void run() {
                // penentuan jalur, langsung masuk home atau ke halaman login
                if (SaveSharedPreference.getUserName(MainActivity.this).length() == 0) {
                    while (mProgressStatus < 100) {
                        mProgressStatus = mProgressStatus + doWork();
                        // Update the progress bar
                        mHandler.post(new Runnable() {
                            public void run() {
                                mProgress.setProgress(mProgressStatus);
                            }
                        });
                    }
                    login();
                } else {
                    while (mProgressStatus < 100) {
                        mProgressStatus = mProgressStatus + doWork();
                        // Update the progress bar
                        mHandler.post(new Runnable() {
                            public void run() {
                                mProgress.setProgress(mProgressStatus);
                            }
                        });
                    }
                    home();
                }
            }
        }).start();

        // ATTENTION: This was auto-generated to implement the App Indexing API.
        // See https://g.co/AppIndexing/AndroidStudio for more information.
        client = new GoogleApiClient.Builder(this).addApi(AppIndex.API).build();
    }

    @Override
    protected void onResume() {
        super.onResume();
    }

    public void onDestroy() {
        super.onDestroy();
    }

    //method untuk menunggu
    public int doWork() {
        int a = 0, b = 0;
        while (a <= 10000000) {
            a++;
        }
        b++;
        return b;
    }

    //ke halaman login
    public void login() {
        Intent intent = new Intent(this, LoginPage.class);
        startActivity(intent);
        finish();
    }

    //method ke halaman home
    public void home() {
        Intent intent = new Intent(this, Home.class);
        intent.putExtra("username", SaveSharedPreference.getUserName(MainActivity.this).trim());
        startActivity(intent);
        finish();
    }

    @Override
    public void onStart() {
        super.onStart();

        // ATTENTION: This was auto-generated to implement the App Indexing API.
        // See https://g.co/AppIndexing/AndroidStudio for more information.
        client.connect();
        Action viewAction = Action.newAction(
                Action.TYPE_VIEW, // TODO: choose an action type.
                "Main Page", // TODO: Define a title for the content shown.
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
                "Main Page", // TODO: Define a title for the content shown.
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
