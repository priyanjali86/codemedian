import { HttpClient, HttpHeaders, HttpErrorResponse } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { ToastController } from 'ionic-angular';
import { Http, Response, Headers, URLSearchParams } from '@angular/http';
import 'rxjs/add/operator/map';
import { LoadingController, Platform, Nav } from 'ionic-angular';
import { Observable } from 'rxjs/Observable';
import 'rxjs/add/operator/catch';
/*
  Generated class for the AppServiceProvider provider.

  See https://angular.io/guide/dependency-injection for more info on providers
  and Angular DI.
*/
@Injectable()
export class AppServiceProvider {
  BASE_URL: any = "https://onlineapi.000webhostapp.com/signup/signup/";
  constructor( private toastCtrl: ToastController, public loadingCtrl: LoadingController, public platform: Platform,public http: HttpClient,) {
    console.log('Hello AppServiceProvider Provider');
  }
  createLoadingBar() {
    return this.loadingCtrl.create({
      spinner: 'bubbles',
      //spinner: 'hide',
      //content: `<div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>`,
      dismissOnPageChange: false,
      //cssClass: 'transparent',
      showBackdrop: true,
      //content: 'Loading data...'
    });
  }



  private handleErrors(error: any):
    Observable<any> {
    //Log error in the browser console
    console.error('observable error: ', error);
    return Observable.throw(error);
  }
  presentToast(msg) {
    let toast = this.toastCtrl.create({
      message: msg,
      duration: 4000,
      position: 'bottom'
    });



    toast.present();
  }
  /*========service-data handler======*/
  private extractData(res: Response) {
    let body = res.json();
    return body || {};
  }
  /*========service-data handler======*/

  /*========error handler======*/
  private handleError(error: any) {
    let errMsg = (error.message) ? error.message :
      error.status ? `${error.status} - ${error.statusText}` : 'Server error';
    console.error(errMsg);
    return Observable.throw(errMsg);
  }
 /*==============Forgot Password start================*/
 login(url: string, formValue
  ): Observable<any> {

    let headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
    let body = JSON.stringify(formValue)
    //console.log(body);
    return this.http
      .post(url, body, { headers: headers })
      .catch(this.handleError);
  }
  /*==============Forgot Password end================*/
  
}
