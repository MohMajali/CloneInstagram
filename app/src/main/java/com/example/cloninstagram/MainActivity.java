package com.example.cloninstagram;

import androidx.annotation.NonNull;
import androidx.appcompat.app.ActionBarDrawerToggle;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.drawerlayout.widget.DrawerLayout;
import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentTransaction;

import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.Gravity;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.example.cloninstagram.authintication.LoginActivity;
import com.example.cloninstagram.fragments.CameraFragment;
import com.example.cloninstagram.fragments.HomeFragment;
import com.example.cloninstagram.fragments.LikesFragment;
import com.example.cloninstagram.fragments.Profileragment;
import com.example.cloninstagram.fragments.SearchFragment;
import com.example.cloninstagram.helper.SharedprefManager;
import com.example.cloninstagram.helper.URL;
import com.example.cloninstagram.helper.VolleyHandler;
import com.example.cloninstagram.models.User;
import com.google.android.material.navigation.NavigationView;
import com.squareup.picasso.Picasso;

import org.json.JSONException;
import org.json.JSONObject;

public class MainActivity extends AppCompatActivity {
    DrawerLayout mDrawerLayout;
    ActionBarDrawerToggle mActionDrawerToggle;
    NavigationView mNavigationView;
    User user;
    String mImageProfile,mEmail,mUsername ;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);


        //layout variables
        mDrawerLayout = findViewById(R.id.main_drawer_layout);
        mNavigationView = findViewById(R.id.main_nav_view);


        mActionDrawerToggle = new ActionBarDrawerToggle(this, mDrawerLayout, R.string.open, R.string.close);
        mDrawerLayout.addDrawerListener(mActionDrawerToggle);
        mActionDrawerToggle.syncState();
        // getSupportActionBar().setDisplayHomeAsUpEnabled(true);

        setSupportActionBar((Toolbar)findViewById(R.id.my_toolbar));
        getSupportActionBar().setTitle("Instagram");
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setHomeAsUpIndicator(R.drawable.ic_home_menu);


        user = SharedprefManager.getInstance(this).getUserData();



        Log.i("oncreate","create");


        //Default fragment to be displayed
        changeFragmentDisplay(R.id.home);

        //listener for navigation view
        mNavigationView.setNavigationItemSelectedListener(new NavigationView.OnNavigationItemSelectedListener() {
            @Override
            public boolean onNavigationItemSelected(@NonNull MenuItem item) {

                changeFragmentDisplay(item.getItemId());
                return true;
            }
        });


    }


    private void changeFragmentDisplay(int item){

        Fragment fragment = null;

        if (item == R.id.home) {
            fragment = new HomeFragment();


        } else if (item == R.id.search) {
            startActivity(new Intent(MainActivity.this,SearchActivity.class));


        } else if (item == R.id.profile) {
            fragment = new Profileragment();



        } else if (item == R.id.like) {
            fragment = new LikesFragment();


        } else if (item == R.id.camera) {
            fragment = new CameraFragment();



        } else if (item == R.id.log_out) {

            logUserOutIFTheyWant();

        } else {
            Toast.makeText(MainActivity.this, "Error", Toast.LENGTH_LONG).show();
        }

        //hide naviagtion drawer
        mDrawerLayout.closeDrawer(Gravity.START);

        if(fragment != null){
            FragmentTransaction ft = getSupportFragmentManager().beginTransaction();
            ft.replace(R.id.main_fragment_content,fragment);
            ft.commit();
        }


    }


    private void logUserOutIFTheyWant(){


        AlertDialog.Builder builder = new AlertDialog.Builder(this);
        builder.setTitle("Log Out");
        builder.setMessage("Are you sure you want to log out?");

        builder.setPositiveButton("Yes", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {

                SharedprefManager sharedPrefrenceManger = SharedprefManager.getInstance(getApplicationContext());
                sharedPrefrenceManger.logUserOut();
                startActivity(new Intent(MainActivity.this,LoginActivity.class));
                dialog.dismiss();


            }
        });


        builder.setNegativeButton("No", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                dialog.dismiss();
            }
        });

        builder.show();
    }


    @Override
    public boolean onOptionsItemSelected(MenuItem item) {

        if (mActionDrawerToggle.onOptionsItemSelected(item)) {
            return true;
        }else if(item.getItemId() == R.id.settings){
            Intent settingsIntent = new Intent(this,SettingsActivity.class);
            settingsIntent.putExtra("imageProfile",mImageProfile);
            settingsIntent.putExtra("email",mEmail);
            settingsIntent.putExtra("username",mUsername);
            startActivity(settingsIntent);
        }
        return super.onOptionsItemSelected(item);
    }


    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.main_menu,menu);
        return super.onCreateOptionsMenu(menu);
    }

    @Override
    protected void onStart() {
        super.onStart();

        boolean isUserLoggedIn = SharedprefManager.getInstance(getApplicationContext()).isUserLogggedIn();

        //check if user is logged in
        if (!isUserLoggedIn) {
            startActivity(new Intent(MainActivity.this, LoginActivity.class));
        } else {

            getUserData();



        }



    }


    @Override
    protected void onPause() {
        super.onPause();
        Log.i("onpause","pause");

    }


    @Override
    protected void onResume() {
        super.onResume();
        Log.i("onresume","resume");

   /*     boolean isUserLoggedIn = SharedPrefrenceManger.getInstance(getApplicationContext()).isUserLogggedIn();

        if (!isUserLoggedIn) {
            startActivity(new Intent(MainActivity.this, LoginActivity.class));
        } else {
            getUserData();

        }
        */


    }


    @Override
    protected void onRestart() {
        super.onRestart();
        Log.i("onrestart","restart");
    }

    @Override
    protected void onStop() {
        super.onStop();
        Log.i("onstop","stop");
    }




    private void getUserData(){


        View navHeader = mNavigationView.getHeaderView(0);
        final ImageView user_iv = navHeader.findViewById(R.id.user_iv);
        final TextView user_name = navHeader.findViewById(R.id.user_name);
        final TextView user_email = navHeader.findViewById(R.id.user_email);

        int user_id = user.getId();
        String username = user.getUsername();
        user_name.setText(username);

        StringRequest stringRequest = new StringRequest(Request.Method.GET, URL.get_user_data+user_id,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {

                        try {
                            JSONObject jsonObject = new JSONObject(response);
                            Log.i("userObjectProfile",jsonObject.toString());

                            if(!jsonObject.getBoolean("error")){


                                JSONObject jsonObjectUser =  jsonObject.getJSONObject("user");

                                mUsername  = jsonObjectUser.getString("username");
                                mEmail  = jsonObjectUser.getString("email");
                                mImageProfile = jsonObjectUser.getString("image");


                                user_email.setText(mEmail);

                                if(!mImageProfile.isEmpty()){
                                    Picasso.with(getApplicationContext()).load(mImageProfile).error(R.drawable.user).into(user_iv);
                                }

                            }else{

                                Toast.makeText(MainActivity.this,jsonObject.getString("message"),Toast.LENGTH_LONG).show();

                            }


                        }catch (JSONException e){
                            e.printStackTrace();
                        }
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Toast.makeText(MainActivity.this,error.getMessage(),Toast.LENGTH_LONG).show();

                    }
                }


        );

        VolleyHandler.getInstance(getApplicationContext()).addRequetToQueue(stringRequest);

    }











}
