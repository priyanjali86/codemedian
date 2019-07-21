import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams } from 'ionic-angular';
import { HttpClient } from '@angular/common/http';
import { AppServiceProvider } from '../../providers/app-service/app-service';
import { ProfilePage } from '../profile/profile';
import { SignUpPage } from '../sign-up/sign-up';
/**
 * Generated class for the LoginPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@IonicPage()
@Component({
  selector: 'page-login',
  templateUrl: 'login.html',
})
export class LoginPage {
  loginForm: any = {}
  constructor(public navCtrl: NavController, public navParams: NavParams, public http: HttpClient, public appservice: AppServiceProvider) {
  }

  ionViewDidLoad() {
    console.log('ionViewDidLoad LoginPage');
  }
  loginAction() {
    if (this.loginForm.username != '' && this.loginForm.username != null && this.loginForm.username != undefined && this.loginForm.password != '' && this.loginForm.password != null && this.loginForm.password != undefined) {
      console.log(this.loginForm);
      let JSONdata = { UserName: this.loginForm.username, Password: this.loginForm.password }
      let loadingPop = this.appservice.createLoadingBar();
      loadingPop.present();
        this.appservice.login(this.appservice.BASE_URL + '/DoLoginUser', JSONdata).subscribe(res => {
          console.log(res);
          if (res[0].ServiceStatus === 1) {
            loadingPop.dismiss();           
            this.navCtrl.setRoot(ProfilePage)
          }
          else
          {
            loadingPop.dismiss();
          this.appservice.presentToast(res.ReturnMessage);
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
    this.navCtrl.push(SignUpPage)
  }

}
