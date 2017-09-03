package br.com.drinksapp.activity;

import android.content.Intent;
import android.os.Handler;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.Window;
import android.view.WindowManager;

import br.com.drinksapp.R;

public class ApresentacaoActivity extends AppCompatActivity {

    private static int splashInterval = 3000;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        this.requestWindowFeature(Window.FEATURE_NO_TITLE);
        getWindow().setFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN,
                WindowManager.LayoutParams.FLAG_FULLSCREEN);

        setContentView(R.layout.activity_apresentacao);

        new Handler().postDelayed(new Runnable() {

            @Override
            public void run() {
                Intent i = new Intent(ApresentacaoActivity.this, LoginActivity.class);
                startActivity(i);
                this.finish();
            }

            private void finish() {
            }
        }, splashInterval);

    };
}
