package com.example.cloninstagram.Adapter;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;

import com.example.cloninstagram.R;
import com.example.cloninstagram.models.Comment;
import com.example.cloninstagram.models.Story;
import com.squareup.picasso.Picasso;

import java.util.ArrayList;

import de.hdodenhof.circleimageview.CircleImageView;

public class CommentListAdapter extends ArrayAdapter<Comment> {



    private Context mContext;
    ArrayList<Comment> commentArrayList;

    public CommentListAdapter(@NonNull Context context, int resource, ArrayList<Comment> list) {
        super(context,resource,list);
        this.mContext = context;

    }



    @Override
    public int getCount() {
        return super.getCount();
    }

    @Nullable
    @Override
    public Comment getItem(int position) {
        return super.getItem(position);
    }

    @Override
    public int getPosition(@Nullable Comment item) {
        return super.getPosition(item);
    }

    @Override
    public long getItemId(int position) {
        return super.getItemId(position);
    }



    @NonNull
    @Override
    public View getView(int position, @Nullable View convertView, @NonNull ViewGroup parent) {

        View view = convertView;

        if(view == null){

            LayoutInflater li = LayoutInflater.from(mContext);
            view = li.inflate(R.layout.comment_single_item,null);
        }
        Comment comment = getItem(position);
        if(comment != null){
            CircleImageView profile_photo = (CircleImageView) view.findViewById(R.id.profile_photo);
            TextView username = view.findViewById(R.id.username_tv);
            TextView comment_text = view.findViewById(R.id.comment_tv);
            TextView time = view.findViewById(R.id.time_tv);




            if(!comment.getProfile_image().isEmpty()) {
                Picasso.with(getContext()).load(comment.getProfile_image()).error(R.drawable.user).into(profile_photo);
            }

            username.setText(comment.getUsername());
            comment_text.setText(comment.getComment_text());


            if(comment.getTime() != null && comment.getTime().length() > 29) {
                String timeComplete = comment.getTime(); //

                String a = timeComplete.substring(4, 10); //month day
                String b = timeComplete.substring(29, timeComplete.length());//year

                time.setText(a + b);

            }



        }


        return view;
    }
}
