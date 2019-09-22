import { Component } from '@angular/core';
import {  NavController, NavParams } from 'ionic-angular';
import { AppServiceProvider } from '../../providers/app-service/app-service';
import { LoginPage } from '../login/login';
/**
 * Generated class for the SignupPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */


@Component({
  selector: 'page-signup',
  templateUrl: 'signup.html',
})
export class SignupPage {
  signupForm: any = {};
  constructor(public navCtrl: NavController, public navParams: NavParams,
    public appservice: AppServiceProvider) {
  }

  ionViewDidLoad() {
    console.log('ionViewDidLoad SignupPage');
  }
  signUpAction() {
    if (this.signupForm.phone != '' && this.signupForm.phone != null && this.signupForm.phone != undefined && (isNaN(this.signupForm.phone)) != true && this.signupForm.password != '' && this.signupForm.password != null && this.signupForm.password != undefined && this.signupForm.cpassword != '' && this.signupForm.cpassword != null && this.signupForm.cpassword != undefined && this.signupForm.password === this.signupForm.cpassword && this.signupForm.fullname != '' && this.signupForm.fullname != null && this.signupForm.fullname != undefined && this.signupForm.email != '' && this.signupForm.email != null && this.signupForm.email != undefined) {
     
      let loadingPop = this.appservice.createLoadingBar();
      loadingPop.present();
      this.appservice.signUp(this.appservice.BASE_URL + '/Signup', this.signupForm).subscribe(res => {
        console.log(res);
        if (res[0].ServiceStatus === 1) {
          loadingPop.dismiss();
          this.appservice.presentToast(res[0].ReturnMessage);
          this.navCtrl.setRoot(LoginPage)
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
    else {
      if(this.signupForm.password != this.signupForm.cpassword)
      {
        this.appservice.presentToast("Password and confirm password should be same");
      }
      else
      {
        this.appservice.presentToast("Please enter all required field");
      }
      
    }
  }
  GoToLoginAction()
  {
    this.navCtrl.push(LoginPage)
  }
}
