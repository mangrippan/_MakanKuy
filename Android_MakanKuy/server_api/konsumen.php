<?php


require_once("Connection.php");
class JsonDisplayUsers {
    function getUsers(){
        //buat koneksinya
        $connection = new Connection();
        $conn = $connection->getConnection();

        //buat responsenya
        $response = array();

        $code = "code";
        $message = "message";

        try{
            //tampilkan semua data dari mysql
            $queryMarker = "SELECT * FROM konsumen";
            $getData = $conn->prepare($queryMarker);
            $getData->execute();

            $result = $getData->fetchAll(PDO::FETCH_ASSOC);

            foreach($result as $data){
                array_push($response,
                    array(
                        'email'=>$data['email'],
                        'nama'=>$data['nama'],
                        'no_telp'=>$data['no_telp'],
                        'saldo'=>$data['saldo']

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

$location = new JsonDisplayUsers();
$location->getUsers();