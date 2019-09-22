import { Component } from '@angular/core';
import {  NavController, NavParams } from 'ionic-angular';
import { HistoryPage } from '../history/history';
import { AppServiceProvider } from '../../providers/app-service/app-service';
/**
 * Generated class for the FrienProfilePage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */


@Component({
  selector: 'page-friend-profile',
  templateUrl: 'friend-profile.html',
})
export class FriendProfilePage {
  id:any; 
  phone:any;
  email:any;
  fullname:any;
  address:any;
  images:any;
  relationshipStatus;
  dob;
  constructor(public navCtrl: NavController, public navParams: NavParams,public appservice: AppServiceProvider) {
    this.id = navParams.get('friendID');
    
  }

  ionViewDidEnter() {
    this.getProfile(this.id);
  }
  getProfile(ID) {
    let loadingPop = this.appservice.createLoadingBar();
    loadingPop.present();
    this.appservice.getProfile(this.appservice.BASE_URL + '/getProfile', ID).subscribe(res => {
      console.log(res);
      if (res[0].ServiceStatus === 1) {
        loadingPop.dismiss();
       
        this.phone = res[0].MobileNumber;
        this.email = res[0].EmailAddress;
        this.fullname = res[0].FullName;
        this.address = res[0].Address;
        this.dob=res[0].DOB;
        this.relationshipStatus=res[0].RelationshipStatus;

        if (res[0].ProfilePicturePath != '') {
          this.images = res[0].ProfilePicturePath;
         
        }
        else {
          this.images = '../../assets/imgs/profile-image.jpg';
         
        }
      }
      else {
        loadingPop.dismiss();
        this.appservice.presentToast(res[0].ReturnMessage);
      }
    }, err => {
      loadingPop.dismiss();
      this.appservice.presentToast(err);
      console.log(err);
    });
  }
  historyAction()
  {
    this.navCtrl.push(HistoryPage);
  }

}
