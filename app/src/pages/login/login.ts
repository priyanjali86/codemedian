import { Component } from '@angular/core';
import { NavController, NavParams } from 'ionic-angular';
import { AppServiceProvider } from '../../providers/app-service/app-service';
import { ProfilePage } from '../profile/profile';
import { SignupPage } from '../signup/signup';
import { TabsPage } from '../tabs/tabs';
import { ViewProfilePage } from '../view-profile/view-profile';
import { HomePage } from '../home/home';

/**
 * Generated class for the LoginPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */


@Component({
  selector: 'page-login',
  templateUrl: 'login.html',
})
export class LoginPage {
  loginForm: any = {};
  passwordType: string = 'password';
  passwordIcon: string = 'eye-off';
  constructor(public navCtrl: NavController, public navParams: NavParams, public appservice: AppServiceProvider) {
  }

  ionViewDidLoad() {
    console.log('ionViewDidLoad LoginPage');
  }
  hideShowPassword() {
    this.passwordType = this.passwordType === 'text' ? 'password' : 'text';
    this.passwordIcon = this.passwordIcon === 'eye-off' ? 'eye' : 'eye-off';
}
  loginAction() {
    if (this.loginForm.phone != '' && this.loginForm.phone != null && this.loginForm.phone != undefined && isNaN(this.loginForm.phone)===false&& this.loginForm.password != '' && this.loginForm.password != null && this.loginForm.password != undefined) {
      console.log(this.loginForm);
      
      let loadingPop = this.appservice.createLoadingBar();
      loadingPop.present();
        this.appservice.login(this.appservice.BASE_URL + '/DoLoginUser', this.loginForm).subscribe(res => {
          console.log(res);
          if (res[0].ServiceStatus === 1) {
            loadingPop.dismiss();   
            localStorage.setItem('user_id',res[0].UserID);
            localStorage.setItem('userName',res[0].FullName);
            localStorage.setItem('userImg',res[0].ProfilePicturePath);
            this.navCtrl.setRoot(TabsPage);
          }
          else
          {
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
      this.appservice.presentToast("All field are mandatory");
    }
  }
  SignUpAction()
  {
    this.navCtrl.push(SignupPage)
  }

}
