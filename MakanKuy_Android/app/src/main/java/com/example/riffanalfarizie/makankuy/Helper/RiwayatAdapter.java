package com.example.riffanalfarizie.makankuy.Helper;

import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import com.example.riffanalfarizie.makankuy.R;

import java.util.ArrayList;

/**
 * Created by Riffan Alfarizie on 10/01/2018.
 */

public class RiwayatAdapter extends RecyclerView.Adapter<RiwayatAdapter.RiwayatViewHolder>{
    private ArrayList<RiwayatModel> riwayatList = null;


    public RiwayatAdapter(ArrayList<RiwayatModel> riwayatList){
        this.riwayatList = riwayatList;
    }

    @Override
    public RiwayatViewHolder onCreateViewHolder(ViewGroup parent, int viewType){
        LayoutInflater layoutInflater = LayoutInflater.from(parent.getContext());
        View view = layoutInflater.inflate(R.layout.row_riwayat,parent,false);
        return new RiwayatViewHolder(view);
    }

    @Override
    public void onBindViewHolder(RiwayatViewHolder viewHolder, int i){
        viewHolder.namaTV.setText(riwayatList.get(i).getNamaResto());
        viewHolder.tanggalTV.setText(riwayatList.get(i).getTglPesan());
        viewHolder.jumlahTV.setText(riwayatList.get(i).getJmlPesan());
        viewHolder.statusTV.setText(riwayatList.get(i).getStatus());
    }

    @Override
    public int getItemCount(){
        return (riwayatList == null) ? 0 : riwayatList.size();
    }

    class RiwayatViewHolder extends RecyclerView.ViewHolder{
        TextView namaTV,tanggalTV,jumlahTV,statusTV;
        RiwayatViewHolder(View view){
            super(view);

            namaTV = (TextView)view.findViewById(R.id.histori_nama);
            tanggalTV = (TextView)view.findViewById(R.id.histori_tanggal);
            jumlahTV = (TextView)view.findViewById(R.id.histori_jumlah);
            statusTV = (TextView)view.findViewById(R.id.histori_status);
        }
    }

}


