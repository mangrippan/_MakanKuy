<?php

namespace user;

class Authentication
{
    private $email = "";
    private $nama = "";
    private $id_konsumen = "";
    private $PASSWORD = "";
    private $no_telp = "";

    private $DB_CONNECTION;
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "makankuy";

    function __construct()
    {
        $this->DB_CONNECTION = mysqli_connect($this->servername, $this->username,
            $this->password, $this->dbname);
    }

    public function prepare($data)
    {   
        if (array_key_exists('email', $data))
            $this->email = $data['email'];

        if (array_key_exists('nama', $data))
            $this->nama = $data['nama'];

        if (array_key_exists('id_konsumen', $data))
            $this->id_konsumen = $data['id_konsumen'];

        if (array_key_exists('password', $data))
            $this->PASSWORD = $data['password'];

        if (array_key_exists('no_telp', $data))
            $this->no_telp = $data['no_telp'];

        if (array_key_exists('id_restoran', $data))
            $this->id_restoran = $data['id_restoran'];

        if (array_key_exists('tanggal_pesan', $data))
            $this->tanggal_pesan = $data['tanggal_pesan'];

        if (array_key_exists('jumlah_pesan', $data))
            $this->jumlah_pesan = $data['jumlah_pesan'];

        if (array_key_exists('deposit', $data))
            $this->deposit = $data['deposit'];

        if (array_key_exists('tanggal_topup', $data))
            $this->tanggal_topup = $data['tanggal_topup'];

        if (array_key_exists('jumlah_topup', $data))
            $this->jumlah_topup = $data['jumlah_topup'];

        if (array_key_exists('bukti', $data))
            $this->bukti = $data['bukti'];

        if (array_key_exists('status', $data))
            $this->status = $data['status'];

        if (array_key_exists('id_restoran', $data))
            $this->id_restoran = $data['id_restoran'];

    }

    

    function isUserValidToLogin() {
        $sql = "SELECT id_konsumen FROM konsumen WHERE id_konsumen = '". $this->id_konsumen."'
         AND password = '".$this->PASSWORD."'";

        $result = mysqli_query($this->DB_CONNECTION, $sql);

        if(mysqli_num_rows($result) > 0) {
            return true;
        }else {
            return false;
        }
    }

    function isUserExisted() {
        $sql = "SELECT id_konsumen FROM konsumen WHERE id_konsumen = '". $this->id_konsumen."' ";

        $result = mysqli_query($this->DB_CONNECTION, $sql);

        if(mysqli_num_rows($result) > 0) {
            return true;
        }else {
            return false;
        }
    }

    function insertNewUserIntoDB () {
        $sql = "INSERT INTO konsumen ( email, nama_konsumen, id_konsumen, password, no_telp) 
        VALUES ( '" . $this->email . "',  '" . $this->nama . "',  '" . $this->id_konsumen . "', '" . $this->PASSWORD . "',  '" . $this->no_telp . "')";

        $result = mysqli_query($this->DB_CONNECTION, $sql);
        if (!$result) {
        printf("Error: %s\n", mysqli_error($this->DB_CONNECTION));
        exit();
        }

        if ($result) {
            $json['success'] = 1;
            $json['message'] ='Berhasil Daftar';

            echo json_encode($json);
        } else {
            $json['success'] = 0;
            $json['message'] ='Gagal Daftar';

            echo json_encode($json);
        }
    }

    function pemesan(){
        $cekKapasitas = " SELECT kapasitas FROM restoran WHERE id_restoran = '" . $this->id_restoran . "' ";
        $cekPesanan = " SELECT SUM(jumlah_pesan) FROM pemesanan WHERE id_restoran = '" . $this->id_restoran . "' AND status = 0 ";

        if($cekPesanan<$cekKapasitas){
            $sql = "INSERT INTO pemesanan ( id_konsumen, id_restoran, tanggal_pesan, jumlah_pesan, deposit) 
            VALUES ( '" . $this->id_konsumen . "',  '" . $this->id_restoran . "',  '" . $this->tanggal_pesan . "', '" . $this->jumlah_pesan . "',  '" . $this->deposit . "')";

            $result = mysqli_query($this->DB_CONNECTION, $sql);
            if (!$result) {
                printf("Error: %s\n", mysqli_error($this->DB_CONNECTION));
                exit();
            }
            if ($result) {
                $json['success'] = 1;
                $json['message'] ='Berhasil pesan';

                echo json_encode($json);
            } else {
                $json['success'] = 0;
                $json['message'] ='Gagal pesan';

                echo json_encode($json);
            }
        }
        else{
                $json['success'] = 2;
                $json['message'] ='Restoran Penuh';

                echo json_encode($json);
        }
    }

    function pemesanann(){
        $sql = "INSERT INTO pemesanan ( id_konsumen, id_restoran, tanggal_pesan, jumlah_pesan, deposit) 
        VALUES ( '" . $this->id_konsumen . "',  '" . $this->id_restoran . "',  '" . $this->tanggal_pesan . "', '" . $this->jumlah_pesan . "',  '" . $this->deposit . "')";

        $result = mysqli_query($this->DB_CONNECTION, $sql);
        if ($result) {
            $json['success'] = 1;
            $json['message'] ='Berhasil pesan';

            echo json_encode($json);
        } else {
            $json['success'] = 0;
            $json['message'] ='Gagal pesan';

            echo json_encode($json);
        }
    }

    function buktiTopup(){
        $sql = "INSERT INTO topup ( id_konsumen, tanggal_topup, jumlah_topup, bukti) 
        VALUES ( '" . $this->id_konsumen . "',  '" . $this->tanggal_topup . "',  '" . $this->jumlah_topup . "', '" . $this->bukti . "')";
        //$sql = "INSERT INTO topup (id_konsumen, tanggal_topup, jumlah_topup, bukti) VALUES ('abc', '2017-12-03 00:00:00', '20000', 'kjandskjsadn')";
        //$sql = "SELECT * FROM topup WHERE id_konsumen = 'abc'";

        $result = mysqli_query($this->DB_CONNECTION, $sql);

        if ($result) {
            $json['success'] = 1;
            $json['message'] ='Berhasil topup';

            echo json_encode($json);
        } else {
            $json['success'] = 0;
            $json['message'] ='Gagal topup';

            echo json_encode($json);
        }
    }

    function profilReq() {
        $sql = "SELECT * FROM konsumen WHERE  id_konsumen = '" . $this->id_konsumen . "'  ";

        $result = mysqli_query($this->DB_CONNECTION, $sql);

        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        if(mysqli_num_rows($result) > 0) {
            $response["id_konsumen"] = $row["id_konsumen"];
            $response["nama"] = $row["nama_konsumen"];
            $response["email"] = $row["email"];
            $response["no_telp"] = $row["no_telp"];
            $response["saldo"] = $row["saldo"];  
            echo json_encode($response);     
            return true;
        }else {
            return false;
        }
    }

    function historiPemesanann() {
        $sql = "SELECT pemesanan.*, restoran.nama FROM pemesanan,restoran WHERE pemesanan.id_konsumen LIKE '" . $this->id_konsumen . "' AND restoran.id_restoran LIKE '" . $this->id_restoran . "'    ";
        //$sql = "SELECT pemesanan.*, restoran.nama FROM pemesanan,restoran WHERE id_konsumen = '" . $this->id_konsumen . "' AND id_restoran = '" . $this->id_restoran . "'    ";
        $result = mysqli_query($this->DB_CONNECTION, $sql);
        //if (!$result) {
        //printf("Error: %s\n", mysqli_error($this->DB_CONNECTION));
        //exit();
        //}
        
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        if(mysqli_num_rows($result) > 0) {
            $response["id_konsumen"] = $row["id_konsumen"];
            $response["restoran.nama"] = $row["id_restoran"];
            $response["tanggal_pesan"] = $row["tanggal_pesan"];
            $response["jumlah_pesan"] = $row["jumlah_pesan"];
            $response["deposit"] = $row["deposit"];  
            echo json_encode($response);     
            return true;
        }else {
            return false;
        }
    }

    function historiP() {
        $sql = "SELECT * FROM pemesanan WHERE id_konsumen LIKE '" . $this->id_konsumen . "' ";
        //$sql = "SELECT pemesanan.*, restoran.nama FROM pemesanan,restoran WHERE id_konsumen = '" . $this->id_konsumen . "' AND id_restoran = '" . $this->id_restoran . "'    ";
        $result = mysqli_query($this->DB_CONNECTION, $sql);
        //if (!$result) {
        //printf("Error: %s\n", mysqli_error($this->DB_CONNECTION));
        //exit();
        //}
        
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        if(mysqli_num_rows($result) > 0) {
            $response["id_konsumen"] = $row["id_konsumen"];
            $response["restoran.nama"] = $row["id_restoran"];
            $response["tanggal_pesan"] = $row["tanggal_pesan"];
            $response["jumlah_pesan"] = $row["jumlah_pesan"];
            $response["deposit"] = $row["deposit"];  
            echo json_encode($response);     
            return true;
        }else {
            return false;
        }
    }
    

}