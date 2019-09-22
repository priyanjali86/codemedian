import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams } from 'ionic-angular';
import { ProfilePage } from '../profile/profile';
import { AppServiceProvider } from '../../providers/app-service/app-service';
import { LoginPage } from '../login/login';
import { EditProfilePage } from '../edit-profile/edit-profile';
/**
 * Generated class for the ViewProfilePage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */


@Component({
  selector: 'page-view-profile',
  templateUrl: 'view-profile.html',
})
export class ViewProfilePage {
  phone:any;
  email:any;
  fullname:any;
  address:any;
  images:any;
  relationshipStatus;
  dob;
  constructor(public navCtrl: NavController, public navParams: NavParams,public appservice: AppServiceProvider) {
  }

  ionViewDidLoad() {
    console.log('ionViewDidLoad ViewProfilePage');
  }
  ionViewDidEnter() {
    this.getProfile();
  }
  getProfile() {
    let loadingPop = this.appservice.createLoadingBar();
    loadingPop.present();
    this.appservice.getProfile(this.appservice.BASE_URL + '/getProfile', localStorage.getItem('user_id')).subscribe(res => {
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

  editProfile()
  {
    this.navCtrl.push(EditProfilePage);
  }
  logout()
  {
    localStorage.removeItem('user_id');
    this.navCtrl.setRoot(LoginPage);
  }

}
