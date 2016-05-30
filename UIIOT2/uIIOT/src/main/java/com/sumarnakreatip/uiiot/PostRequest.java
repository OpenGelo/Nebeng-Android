package com.sumarnakreatip.uiiot;

import android.os.AsyncTask;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;

import com.loopj.android.http.AsyncHttpClient;
import com.loopj.android.http.RequestParams;
import com.loopj.android.http.TextHttpResponseHandler;

/**
 * Class PostRequest Merupakan AppCompatActivity
 * Class dipanggil untuk melakukan post request
 *
 * @author  Sanadhi Sutandi
 * @version 0.3
 * @since   2016-05
 */

public class PostRequest extends AppCompatActivity {

    private static final String BASE_URL = "http://green.ui.ac.id/nebeng/back-system/";
    private String requestURL;
    private AsyncHttpClient client;
    private RequestParams params;

    public PostRequest(String relativeUrl){
        client = new AsyncHttpClient();
        params = new RequestParams();
        requestURL = BASE_URL + relativeUrl;
    }

    public void setPostValues(String key, String value){
        params.put(key,value);
    }

    public void executePost(){
        executePostRequest asyncRate = new executePostRequest();
        asyncRate.execute();
    }

    public class executePostRequest extends AsyncTask<Void, String, String> {

        @Override
        protected void onPreExecute() {
            super.onPreExecute();
        }

        @Override
        protected String doInBackground(Void... params) {
            doHttpPost();
            return "";
        }

        @Override
        protected void onPostExecute(String rate) {

        }

    }

    void doHttpPost() {
        client.post(requestURL, params, new TextHttpResponseHandler(){
            @Override
            public void onSuccess(int statusCode, String response) {
                Log.i("Post_Response",response);
            }
        });
    }
}
