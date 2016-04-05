package com.sumarnakreatip.uiiot;

import android.annotation.SuppressLint;

import com.google.gson.Gson;
import com.loopj.android.http.AsyncHttpClient;
import com.loopj.android.http.AsyncHttpResponseHandler;
import com.loopj.android.http.RequestParams;

import java.util.Arrays;
import java.util.List;

@SuppressLint("Instantiatable")
public class StatusHttpClient {
    String et;

    public StatusHttpClient(String s) {
        et = s.toString();
    }

    private static final String HOST = "green.ui.ac.id";
    private final AsyncHttpClient client = new AsyncHttpClient();

    public static class Product {
        public String nama;
        public String no_hp;
        public String email;
        public String status;
    }

    public static class GetAllProducts {
        public String success;
        public String message;
        public Product[] hasil;
    }

    public interface Function<I, O> {
        O call(I input);
    }

    public void get_all_products(final Function<List<Product>, Void> callback) {
        System.out.println("masuk");
        RequestParams params = new RequestParams();
        params.put("username", et);
        client.post("http://" + HOST + "/nebeng/back-system/nebeng_status.php", params, new AsyncHttpResponseHandler() {
            @Override
            public void onSuccess(String response) {
                Gson g = new Gson();
                final GetAllProducts r = g.fromJson(response, GetAllProducts.class);
                final List<Product> list = Arrays.asList(r.hasil);
                callback.call(list);
                System.out.println(Arrays.asList(r.hasil));
            }
        });
    }

}