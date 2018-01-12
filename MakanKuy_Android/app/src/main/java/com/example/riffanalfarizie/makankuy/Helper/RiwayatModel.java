package com.example.riffanalfarizie.makankuy.Helper;

/**
 * Created by Riffan Alfarizie on 10/01/2018.
 */

public class RiwayatModel {
    private String namaResto;
    private String tglPesan;
    private Integer jmlPesan;
    private Integer status;

    public RiwayatModel(String namaResto, String tglPesan, Integer jmlPesan, Integer status) {
        this.namaResto = namaResto;
        this.tglPesan = tglPesan;
        this.jmlPesan = jmlPesan;
        this.status = status;
    }

    public String getNamaResto() {
        return namaResto;
    }

    public String getTglPesan() {
        return tglPesan;
    }

    public Integer getJmlPesan() {
        return jmlPesan;
    }

    public Integer getStatus() {
        return status;
    }

    public void setNamaResto(String namaResto) {
        this.namaResto = namaResto;
    }

    public void setTglPesan(String tglPesan) {
        this.tglPesan = tglPesan;
    }

    public void setJmlPesan(Integer jmlPesan) {
        this.jmlPesan = jmlPesan;
    }

    public void setStatus(Integer status) {
        this.status = status;
    }
}
