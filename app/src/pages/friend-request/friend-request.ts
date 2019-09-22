import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams } from 'ionic-angular';
import { UserListPage } from '../user-list/user-list';
import { AppServiceProvider } from '../../providers/app-service/app-service';
/**
 * Generated class for the FriendRequestPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@IonicPage()
@Component({
  selector: 'page-friend-request',
  templateUrl: 'friend-request.html',
})
export class FriendRequestPage {
  PendingList:any;
  msg;
  constructor(public navCtrl: NavController, public navParams: NavParams,public appservice: AppServiceProvider) {
  }
  ionViewDidEnter() {
    this.getPendingList();
  }
  getPendingList()
  {
    this.appservice.getPendingRequestsList(this.appservice.BASE_URL + '/getPendingRequests?UserID='+localStorage.getItem('user_id'), localStorage.getItem('user_id')).subscribe(res => {
      if (res[0].ServiceStatus === 1) 
      {
        console.log(res[0].PendingList);
        if(res[0].PendingList.length>0)
        {
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

  allUserList()
  {
    this.navCtrl.push(UserListPage);
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

}
