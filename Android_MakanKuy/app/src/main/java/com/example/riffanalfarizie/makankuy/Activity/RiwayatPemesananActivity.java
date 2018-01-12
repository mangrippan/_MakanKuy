 package com.example.riffanalfarizie.makankuy.Activity;

import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.DefaultItemAnimator;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.util.Log;
import android.view.View;

import com.example.riffanalfarizie.makankuy.Helper.ApiClient;
import com.example.riffanalfarizie.makankuy.Helper.ApiService;
import com.example.riffanalfarizie.makankuy.Helper.JSONResponse;
import com.example.riffanalfarizie.makankuy.Helper.MsgModel;
import com.example.riffanalfarizie.makankuy.Helper.RiwayatAdapter;
import com.example.riffanalfarizie.makankuy.Helper.RiwayatModel;
import com.example.riffanalfarizie.makankuy.Helper.RiwayatModelList;
import com.example.riffanalfarizie.makankuy.Helper.SessionManager;
import com.example.riffanalfarizie.makankuy.R;

import org.json.JSONException;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;
import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;

 public class RiwayatPemesananActivity extends AppCompatActivity {

     private RiwayatAdapter viewAdapter;
     private RecyclerView recyclerView;
     RecyclerView.LayoutManager layoutManager;
     RecyclerView.Adapter adapter;
     private List<RiwayatModel> results = new ArrayList<>();

     ApiService apiService;
     SessionManager session;
     String getUsername;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_riwayat_pemesanan);

        session = new SessionManager(this);
        getUsername = session.getId();

        recyclerView = (RecyclerView)findViewById(R.id.recycler_histori);

        apiService = ApiClient.getClient().create(ApiService.class);
        Call<RiwayatModelList> riwayatCall = apiService.getHistori(getUsername);
        riwayatCall.enqueue(new Callback<RiwayatModelList>() {
            @Override
            public void onResponse(Call<RiwayatModelList> call, Response<RiwayatModelList> response) {
                generateRiwayatList(response.body().getRiwayatArrayList());
            }

            @Override
            public void onFailure(Call<RiwayatModelList> call, Throwable t) {

            }
        });

    }

    private void generateRiwayatList(List<RiwayatModel> dataList){
        /*viewAdapter= new RiwayatAdapter(dataList);
        RecyclerView.LayoutManager layoutManager = new LinearLayoutManager(RiwayatPemesananActivity.this);
        recyclerView.setLayoutManager(layoutManager);
        recyclerView.setHasFixedSize(true);
        recyclerView.setAdapter(viewAdapter);*/
        viewAdapter = new RiwayatAdapter(this, results);
        RecyclerView.LayoutManager mLayoutManager = new LinearLayoutManager(getApplicationContext());
        recyclerView.setLayoutManager(mLayoutManager);
        recyclerView.setItemAnimator(new DefaultItemAnimator());
        recyclerView.setAdapter(viewAdapter);
    }


}
