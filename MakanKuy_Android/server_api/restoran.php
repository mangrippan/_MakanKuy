<?php


require_once("Connection.php");
class JsonDisplayMarker {
    function getMarkers(){
        //buat koneksinya
        $connection = new Connection();
        $conn = $connection->getConnection();

        //buat responsenya
        $response = array();

        $code = "code";
        $message = "message";

        try{
            //tampilkan semua data dari mysql
            $queryMarker = "SELECT * FROM restoran WHERE status = 1";
            $getData = $conn->prepare($queryMarker);
            $getData->execute();

            $result = $getData->fetchAll(PDO::FETCH_ASSOC);

            foreach($result as $data){
                array_push($response,
                    array(
                        'id_restoran'=>$data['id_restoran'],
                        'nama'=>$data['nama'],
                        'kategori'=>$data['kategori'],
                        'jalan'=>$data['jalan'],
                        'kecamatan'=>$data['kecamatan'],
                        'detail_tempat'=>$data['detail_tempat'],
                        'no_telp'=>$data['no_telp'],
                        'rating'=>$data['rating'],
                        'foto'=>"http://192.168.137.1/MakanKuyWeb/assets/image_upload/".$data['foto'],
                        'jam_buka'=>$data['jam_buka'],
                        'jam_tutup'=>$data['jam_tutup'],
                        'kapasitas'=>$data['kapasitas'],
                        'longitude'=>$data['longitude'],
                        'latitude'=>$data['latitude']

                        )
                    );
            }
        }catch (PDOException $e){
            echo "Failed displaying data".$e->getMessage();
        }

        //buatkan kondisi jika berhasil atau tidaknya
        if($queryMarker){
            echo json_encode(
                array("data"=>$response,$code=>1,$message=>"Success")
            );
        }else{
            echo json_encode(
                array("data"=>$response,$code=>0,$message=>"Failed displaying data")
            );
        }


    }
}

$location = new JsonDisplayMarker();
$location->getMarkers();