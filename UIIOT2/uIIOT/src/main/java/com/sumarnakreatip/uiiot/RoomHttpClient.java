package com.sumarnakreatip.uiiot;

import android.app.Activity;
import android.widget.Toast;

import com.google.gson.Gson;
import com.loopj.android.http.AsyncHttpClient;
import com.loopj.android.http.AsyncHttpResponseHandler;
import com.loopj.android.http.RequestParams;

import org.apache.http.Header;

import java.util.Arrays;
import java.util.List;

/**
 * Class MyInstanceIDListenerService Merupakan Callback untuk mendapat seluruh tebengan
 *
 * @author  Sanadhi Sutandi, Suryo
 * @version 0.3
 * @since   2016-03
 */

public class RoomHttpClient extends Activity {

    private static final String HOST = "green.ui.ac.id";
    private final AsyncHttpClient client = new AsyncHttpClient();

    //kelas untuk isi data
    public static class Product {
        public String user_id;
        public String id_tebengan;
        public String npm;
        public String nama;
        public String username;
        public String asal;
        public String tujuan;
        public String kapasitas;
        public String waktu_berangkat;
        public String jam_berangkat;
        public String keterangan;
    }

    //kelas paket data
    public static class GetAllProducts {
        public String success;
        public String message;
        public Product[] result;
    }

    //fungsi untuk pengambilan data
    public interface Function<I, S, O> {
        O call(I input, S sukses);
    }

    //method untuk pengambilan data dari server
    public void get_all_products(final Function<List<Product>, String, Void> callback) {
        RequestParams params = new RequestParams("kode", "1");
        client.post("http://" + HOST + "/nebeng/back-system/get_all_tebengan.php", params, new AsyncHttpResponseHandler() {

//            public void onProgress(int bytesWritten, int totalSize) {
//                Toast.makeText(getApplicationContext(), "Requested resource not found", Toast.LENGTH_LONG).show();
//            }

            public void onSuccess(String response) {
                Gson g = new Gson();
                try{
                    final GetAllProducts r = g.fromJson(response, GetAllProducts.class);
                    final List<Product> list = Arrays.asList(r.result);
                    final String sukses = r.success;
                    callback.call(list, sukses);
                }
                catch (Exception e){
                    Toast.makeText(getApplication(), "Koneksi Internet Buruk", Toast.LENGTH_LONG).show();
                }
            }

            @Override
            public void onFailure(int arg0, Header[] arg1, byte[] arg2, Throwable arg3) {
                // TODO Auto-generated method stub
                super.onFailure(arg0, arg1, arg2, arg3);
                arg3.printStackTrace();
            }

            @Override
            public void onFinish() {
                // TODO Auto-generated method stub
                super.onFinish();
            }

            @Override
            public void onStart() {
                // TODO Auto-generated method stub
                super.onStart();
            }

        });
    }
}