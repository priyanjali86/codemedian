import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams } from 'ionic-angular';
import { FriendProfilePage } from '../friend-profile/friend-profile';
import { AppServiceProvider } from '../../providers/app-service/app-service';
/**
 * Generated class for the FriendListPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@IonicPage()
@Component({
  selector: 'page-friend-list',
  templateUrl: 'friend-list.html',
})
export class FriendListPage {
  toUser : any=[];
  userList:any;
  friendlistCount;
  constructor(public navCtrl: NavController, public navParams: NavParams, public appservice: AppServiceProvider) {

   
  //   this.toUser = {
  //     toUserId:'210000198410281948',
  //     toUserName:'Hancock',
  //   },
  //   {
  //     toUserId:'210000198410281950',
  //     toUserName:'Goutam'

  //   },
  //   {
  //     toUserId:'210000198410281952',
  //     toUserName:'Manu'

  //   }

  }

  ionViewDidEnter() {
    this.getAllUser();
  }
  getAllUser()
  {
    this.appservice.getFriendList(this.appservice.BASE_URL + '/UserFriendList', localStorage.getItem('user_id')).subscribe(res => {
      console.log(res);
      this.userList=res[0].UserFriendList;
      this.friendlistCount=this.userList.length;
      console.log(this.userList);
      for(let i=0;i<this.userList.length;i++)
      {
        this.toUser.push({
          "toUserId":this.userList[i].FriendUserID,
          "toUserName":this.userList[i].FriendFullName
        })
      }
    });
  }
  frndProfileAction()
  {
    this.navCtrl.push(FriendProfilePage);
  }

}
