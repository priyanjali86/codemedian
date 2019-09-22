import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams } from 'ionic-angular';
import { FriendProfilePage } from '../friend-profile/friend-profile';
import { AppServiceProvider } from '../../providers/app-service/app-service';
import { FriendRequestPage } from '../friend-request/friend-request';
/**
 * Generated class for the FriendListPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@IonicPage()
@Component({
  selector: 'page-friend-list',
  templateUrl: 'user-list.html',
})
export class UserListPage {
  toUser : any=[];
  userList:any;
  PendingList:any;
  msg;
  constructor(public navCtrl: NavController, public navParams: NavParams, public appservice: AppServiceProvider) {
   
  }

  ionViewDidEnter() {
    this.getAllUser();
    this.getPendingList();
  }
  
  getPendingList()
  {
    this.appservice.getPendingRequestsList(this.appservice.BASE_URL + '/getPendingRequests?UserID='+localStorage.getItem('user_id'), localStorage.getItem('user_id')).subscribe(res => {
      if (res[0].ServiceStatus === 1) 
      {
        console.log(res[0].PendingList);
        if(res[0].PendingList.length>0)        {
          this.PendingList=res[0].PendingList;
        }
        else
        {
          this.PendingList='';
          this.msg="No Pending Request";
        }
      
        console.log(this.PendingList);
      }
     
      
    });
  }
  getAllUser()
  {
    console.log(localStorage.getItem('user_id'));
    this.appservice.getAllUserList(this.appservice.BASE_URL + '/getAllUsers?UserID='+localStorage.getItem('user_id'), localStorage.getItem('user_id')).subscribe(res => {
      
      this.userList=res[0].UsersList;
     
      for(let i=0;i<this.userList.length;i++)
      {
        this.toUser.push({
          "toUserId":this.userList[i].UserID,
          "toUserName":this.userList[i].Full_Name
        })
      }
    });
  }
  frndProfileAction(ID)
  {
    this.navCtrl.push(FriendProfilePage,{friendID: ID});
  }
  sendRequest(friendsID)
  {
    this.appservice.sendFriendRequest(this.appservice.BASE_URL + '/postFriendRequest?UserID='+localStorage.getItem('user_id')+'&FriendID='+friendsID, localStorage.getItem('user_id'),friendsID).subscribe(res => {
   console.log(friendsID);
   this.appservice.presentToast(res[0].ReturnMessage);
   this.getAllUser();
    });
  }

  friendRequest(){
    this.navCtrl.push(FriendRequestPage);
  }
  acceptAction(friendList_ID)
  {
    this.appservice.approvePendingRequests(this.appservice.BASE_URL + '/approvePendingRequests?UserID='+localStorage.getItem('user_id')+'&friend_listID='+friendList_ID, localStorage.getItem('user_id'),friendList_ID).subscribe(res => {
    console.log(res);
    if (res[0].ServiceStatus === 1) 
    {
    this.appservice.presentToast(res[0].ReturnMessage);
  this.getPendingList();  
  }
    });
  }

  userseg: string = "alluser";
  isAndroid: boolean = false;
}
