package com.sumarnakreatip.uiiot;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.view.Window;
import android.widget.ProgressBar;

/**
 * Class MainActivity Merupakan Activity utama
 * Menentukan render halaman aplikasi
 *
 * @author  Sanadhi Sutandi, Suryo
 * @version 0.3
 * @since   2016-03
 */

public class MainActivity extends Activity {

    private ProgressBar mProgress;
    private int mProgressStatus = 0;

    Context context;

    //control handler   
    private Handler mHandler = new Handler();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        requestWindowFeature(Window.FEATURE_NO_TITLE);

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
}
