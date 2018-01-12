package com.example.riffanalfarizie.makankuy.Activity;

import android.Manifest;
import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.pm.PackageManager;
import android.location.Criteria;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.location.LocationProvider;
import android.support.annotation.NonNull;
import android.support.v4.app.FragmentActivity;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.Toast;

import com.example.riffanalfarizie.makankuy.Helper.ApiClient;
import com.example.riffanalfarizie.makankuy.Helper.ApiService;
import com.example.riffanalfarizie.makankuy.Helper.ListRestoranModel;
import com.example.riffanalfarizie.makankuy.Helper.RestoranModel;
import com.example.riffanalfarizie.makankuy.Helper.MarkerTag;
import com.example.riffanalfarizie.makankuy.Helper.SessionManager;
import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.OnMapReadyCallback;
import com.google.android.gms.maps.SupportMapFragment;
import com.google.android.gms.maps.model.CameraPosition;
import com.google.android.gms.maps.model.Circle;
import com.google.android.gms.maps.model.CircleOptions;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.Marker;
import com.google.android.gms.maps.model.MarkerOptions;
import com.example.riffanalfarizie.makankuy.R;
import com.google.maps.android.SphericalUtil;

import java.util.ArrayList;
import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class MapsActivity extends AppCompatActivity implements OnMapReadyCallback, LocationListener, GoogleMap.OnMyLocationButtonClickListener,
        GoogleMap.OnMyLocationClickListener, GoogleMap.OnInfoWindowClickListener{

    private GoogleMap mMap;
    private List<RestoranModel> mListMarker = new ArrayList<>();
    private LocationManager locationManager = null;
    private Marker currentLocationMarker = null;
    private String provider = null;
    private Integer radius = 3000;
    public static final String Pref = "Pref";
    private Circle circle;
    private String id;
    private Marker marker;
    MarkerTag markerTag = new MarkerTag();
    private Integer mId = 0;
    private Integer temp;
    SessionManager session;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_maps);
        // Obtain the SupportMapFragment and get notified when the map is ready to be used.
        SupportMapFragment mapFragment = (SupportMapFragment) getSupportFragmentManager().findFragmentById(R.id.map);
        mapFragment.getMapAsync(this);

        Button buttonTambah = (Button) findViewById(R.id.maps_tambah);
        Button buttonKurang = (Button) findViewById(R.id.maps_kurang);

        buttonTambah.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                temp = 0;
                mId = 0;
                markerTag.setMarkerID(mId);
                radius=radius+1000;
                Location location = locationManager.getLastKnownLocation(provider);
                updateWithNewLocation(location);
                id = null;
                marker.remove();
                mListMarker.clear();
                mMap.clear();

                getData();
                addBoundary(location.getLatitude(),location.getLongitude());
            }
        });

        buttonKurang.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                temp = 0;
                mId = 0;
                markerTag.setMarkerID(mId);
                radius=radius-1000;
                Location location = locationManager.getLastKnownLocation(provider);
                updateWithNewLocation(location);
                id = null;
                marker.remove();
                mListMarker.clear();
                mMap.clear();

                getData();
                addBoundary(location.getLatitude(),location.getLongitude());
            }
        });
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.main, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()){
            case R.id.menu_logout:
                SharedPreferences preferences = getSharedPreferences(session.KEY_UNAME,Context.MODE_PRIVATE);
                SharedPreferences.Editor editor = preferences.edit();
                editor.clear();
                editor.commit();
                startActivity(new Intent(MapsActivity.this,LoginActivity.class));
                finish();
                return true;
            case R.id.menu_profile:
                Intent i = new Intent(this, ProfileActivity.class);
                startActivity(i);
                return true;
            case R.id.menu_topup:
                Intent j = new Intent(this, TopupActivity.class);
                startActivity(j);
                return true;
            case R.id.menu_status:
                startActivity(new Intent(MapsActivity.this, RiwayatPemesananActivity.class));
            default:
                return super.onOptionsItemSelected(item);
        }
    }


    @Override
    public void onMapReady(GoogleMap googleMap){
        mMap = googleMap;
        getData();

        mMap.setMapType(GoogleMap.MAP_TYPE_NORMAL);
        if (isProviderAvailable() && (provider != null)){
            locateCurrentPosition();
        }
        mMap.setMyLocationEnabled(true);
        mMap.setOnMyLocationButtonClickListener(this);
        mMap.setOnMyLocationClickListener(this);
        mMap.setOnInfoWindowClickListener(this);
    }

    @Override
    public void onMyLocationClick(@NonNull Location location) {
        Location curLoc = new Location(location);
        Toast.makeText(this, "Current location:\n" + curLoc, Toast.LENGTH_LONG).show();
    }

    @Override
    public boolean onMyLocationButtonClick() {

        CameraPosition cameraPosition = new CameraPosition.Builder().target(currentLocationMarker.getPosition()).zoom(13f).build();

        if (mMap != null)
            mMap.animateCamera(CameraUpdateFactory.newCameraPosition(cameraPosition));

        return false;
    }


    private void locateCurrentPosition(){
        int status = getPackageManager().checkPermission(Manifest.permission.ACCESS_COARSE_LOCATION,getPackageName());

        if (status == PackageManager.PERMISSION_GRANTED){
            Location location = locationManager.getLastKnownLocation(provider);
            updateWithNewLocation(location);
            locationManager.requestLocationUpdates(provider, 5000, 5.0f, this);
        }


    }

    private boolean isProviderAvailable(){
        locationManager = (LocationManager) getSystemService(Context.LOCATION_SERVICE);
        Criteria criteria = new Criteria();
        criteria.setAccuracy(Criteria.ACCURACY_COARSE);
        criteria.setAltitudeRequired(false);
        criteria.setCostAllowed(true);
        criteria.setPowerRequirement(Criteria.POWER_LOW);

        provider = locationManager.getBestProvider(criteria, true);
        if (locationManager.isProviderEnabled(LocationManager.NETWORK_PROVIDER)){
            provider = LocationManager.NETWORK_PROVIDER;
            return true;
        }

        if (locationManager.isProviderEnabled(LocationManager.GPS_PROVIDER)){
            provider = LocationManager.GPS_PROVIDER;
            return true;
        }

        if (provider != null){
            return true;
        }
        return false;
    }

    private void updateWithNewLocation(Location location){
        if (location != null && provider != null) {
            double lng = location.getLongitude();
            double lat = location.getLatitude();

            addBoundary(lat, lng);

            CameraPosition cameraPosition = new CameraPosition.Builder().target(new LatLng(lat, lng)).zoom(13f).build();

            if (mMap != null)
                mMap.animateCamera(CameraUpdateFactory.newCameraPosition(cameraPosition));

        }
        else {
            Log.d("Location Error", "Something went Wrong");
        }
    }

    private void addBoundary(double lat, double lng){
        MarkerOptions markerOptions = new MarkerOptions();
        markerOptions.position(new LatLng(lat,lng));
        markerOptions.anchor(0.5f,0.5f);

        if(circle!=null){
            circle.remove();
        }
        CircleOptions circleOptions = new CircleOptions().center(new LatLng(lat,lng)).radius(radius).strokeColor(0x110000FF).strokeWidth(1).fillColor(0x110000FF);
        circle = mMap.addCircle(circleOptions);
        if (currentLocationMarker != null)
            currentLocationMarker.remove();
        currentLocationMarker = mMap.addMarker(markerOptions.title("My Location").visible(false));
    }

    @Override
    public void onLocationChanged(Location location) {

        updateWithNewLocation(location);
    }

    @Override
    public void onProviderDisabled(String provider) {

        updateWithNewLocation(null);
    }

    @Override
    public void onProviderEnabled(String provider) {

    }

    @Override
    public void onStatusChanged(String provider, int status, Bundle extras) {
        switch (status) {
            case LocationProvider.OUT_OF_SERVICE:
                break;
            case LocationProvider.TEMPORARILY_UNAVAILABLE:
                break;
            case LocationProvider.AVAILABLE:
                break;
        }
    }

    private void getData(){
        final ProgressDialog dialog = new ProgressDialog(this);
        dialog.setMessage("Menampilkan Data");;
        dialog.show();

        ApiService apiService = ApiClient.getClient().create(ApiService.class);
        Call<ListRestoranModel> call = apiService.getAllLocation();
        call.enqueue(new Callback<ListRestoranModel>() {
            @Override
            public void onResponse(Call<ListRestoranModel> call, Response<ListRestoranModel> response) {
                dialog.dismiss();
                mListMarker = response.body().getmData();
                initMarker(mListMarker);
            }

            @Override
            public void onFailure(Call<ListRestoranModel> call, Throwable t) {
                dialog.dismiss();
                Toast.makeText(MapsActivity.this, t.getMessage(), Toast.LENGTH_SHORT).show();
            }
        });
    }

    private void initMarker(List<RestoranModel> listData){
        temp = 0;
        for (int i=0; i<mListMarker.size(); i++, mId++){
            //set latlng
            LatLng location = new LatLng(Double.parseDouble(mListMarker.get(i).getLatitude()),Double.parseDouble(mListMarker.get(i).getLongitude()));
            //nambah marker
            temp = markerTag.setMarkerID(mId);
            marker = mMap.addMarker(new MarkerOptions().position(location).title(mListMarker.get(i).getNama()).visible(false).snippet(Integer.toString(temp)));
            marker.setTag(temp);
            //set latlng index ke 0
            LatLng latLng = new LatLng(Double.parseDouble(mListMarker.get(0).getLatitude()),Double.parseDouble(mListMarker.get(0).getLongitude()));

            //menampilkan marker dibuffer
            if(SphericalUtil.computeDistanceBetween(location,currentLocationMarker.getPosition())<radius){
                marker.setVisible(true);
            }
        }
    }

    @Override
    public void onInfoWindowClick(Marker marker) {
        Intent intent = new Intent(MapsActivity.this,Detail_RestoActivity.class);
        Bundle bundle = new Bundle();
        //String id = marker.getId();
        id = null;
        id = marker.getId();
        id = id.substring(1);

        //get long lat user
        Location location = locationManager.getLastKnownLocation(provider);
        updateWithNewLocation(location);
        Double curLatitude= location.getLatitude();
        Double curLongitude = location.getLongitude();
        String sLatitude = curLatitude.toString();
        String sLongitude = curLongitude.toString();
        curLatitude = Double.parseDouble(sLatitude);
        curLongitude = Double.parseDouble(sLongitude);

        String m = marker.getSnippet();
        Integer mi = Integer.parseInt(m);
        //Passing data ke activity detail
        bundle.putString("idRestoran", mListMarker.get(mi).getIdRestoran());
        bundle.putString("nama", mListMarker.get(mi).getNama());
        bundle.putString("kategori", mListMarker.get(mi).getKategori());
        bundle.putString("jalan", mListMarker.get(mi).getJalan());
        bundle.putString("kecamatan", mListMarker.get(mi).getKecamatan());
        bundle.putString("detailTempat", mListMarker.get(mi).getDetail_tempat());
        bundle.putString("noTelp", mListMarker.get(mi).getNo_telp());
        bundle.putFloat("rating", mListMarker.get(mi).getRating());
        bundle.putString("foto", mListMarker.get(mi).getFoto());
        bundle.putString("jamBuka", mListMarker.get(mi).getJam_buka());
        bundle.putString("jamTutup", mListMarker.get(mi).getJam_tutup());
        bundle.putInt("kapasitas", mListMarker.get(mi).getKapasitas());
        bundle.putString("longitude", mListMarker.get(mi).getLongitude());
        bundle.putString("latitude", mListMarker.get(mi).getLatitude());
        bundle.putDouble("currentLatitude", curLatitude);
        bundle.putDouble("currentLongitude", curLongitude);
        //Toast.makeText(this, temp, Toast.LENGTH_SHORT).show();

        intent.putExtra("bund",bundle);
        startActivity(intent);

    }
}
