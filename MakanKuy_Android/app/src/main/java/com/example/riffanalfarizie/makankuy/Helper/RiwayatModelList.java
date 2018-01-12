package com.example.riffanalfarizie.makankuy.Helper;

import com.google.gson.annotations.SerializedName;

import java.util.ArrayList;

/**
 * Created by Riffan Alfarizie on 10/01/2018.
 */

public class RiwayatModelList {
    @SerializedName("riwayatList")
    private ArrayList<RiwayatModel> employeeList;

    public ArrayList<RiwayatModel> getRiwayatArrayList() {
        return employeeList;
    }

    public void setEmployeeArrayList(ArrayList<RiwayatModel> riwayatArrayList) {
        this.employeeList = riwayatArrayList;
    }
}
