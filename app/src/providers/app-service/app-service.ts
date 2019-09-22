import { HttpClient, HttpHeaders, HttpErrorResponse } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { ToastController } from 'ionic-angular';
import { Http, Response, Headers, URLSearchParams } from '@angular/http';
import 'rxjs/add/operator/map';
import { LoadingController, Platform, Nav } from 'ionic-angular';
import { Observable } from 'rxjs/Observable';
import 'rxjs/add/operator/catch';
const  TEST_URL: any = "https://onlineapi.000webhostapp.com/signup/signup/";
const PRODUCTION_URL:any="http://dev.glocaltechsol.com/";
const LIVE_URL:any="http://optigooapp.optigoo.com";
/*
  Generated class for the AppServiceProvider provider.

  See https://angular.io/guide/dependency-injection for more info on providers
  and Angular DI.
*/
@Injectable()
export class AppServiceProvider {
 
  
  BASE_URL:any=LIVE_URL;
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
    let JSONdata = { MobileNumber: formValue.phone, Password: formValue.password }
    let headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
    let body = JSON.stringify(JSONdata);
    //console.log(body);
    return this.http
      .post(url, body, { headers: headers })
      .catch(this.handleError);
  }
  /*==============Forgot Password end================*/
  signUp(url: string, formValue
    ): Observable<any> {
      let JSONdata = { FullName: formValue.fullname, Password: formValue.password, MobileNo: formValue.phone, EmailID: formValue.email,DOB:formValue.dob,RelationshipStatus:formValue.RelationshipStatus }
      let headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
      let body = JSON.stringify(JSONdata);
      //console.log(body);
      return this.http
        .post(url, body, { headers: headers })
        .catch(this.handleError);
    }
    getProfile(url: string, userId
      ): Observable<any> {
        let JSONdata = { UserID:userId };
        let headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
        let body = JSON.stringify(JSONdata)

        return this.http
        .post(url, body, { headers: headers })
        .catch(this.handleError);
    }
    profileSave(url: string, formValue
      ): Observable<any>
    {
      let JSONdata = {
        "UserID": formValue.userId, "MobileNumber": formValue.phone, "EmailAddress": formValue.email, "FullName": formValue.fullname, "Address": formValue.address,"DOB":formValue.dob,"RelationshipStatus":formValue.RelationshipStatus,  "PictureFileBase64": formValue.images, "FileName": "abc", "IsUpdatePicture": formValue.isUpdate
      }
      let headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
      let body = JSON.stringify(JSONdata)
console.log(body);
      return this.http
      .post(url, body, { headers: headers })
      .catch(this.handleError);
    }
    getAllUserList(url: string, formValue
      ): Observable<any>
    {
      let JSONdata = {
        "UserID": formValue.userId
      }
    //  let headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
      let body = JSON.stringify(JSONdata)
console.log(body);
      return this.http
      .post(url, body, { })
      .catch(this.handleError);
    }
    sendFriendRequest(url: string, userId,FriendID
      ): Observable<any>
    {
      let JSONdata = {
        "UserID": userId,
        "FriendID":FriendID
      }
    //  let headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
      let body = JSON.stringify(JSONdata)
console.log(body);
      return this.http
      .post(url, body, { })
      .catch(this.handleError);
    } 
    getPendingRequestsList(url: string, userId
      ): Observable<any>
    {
      let JSONdata = {
        "UserID": userId
      }
    //  let headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
      let body = JSON.stringify(JSONdata)
console.log(body);
      return this.http
      .post(url, body, { })
      .catch(this.handleError);
      
    }
    approvePendingRequests(url: string, userId,FriendID
      ): Observable<any>
    {
      let JSONdata = {
        "UserID": userId,
        "friend_listID":FriendID
      }
    //  let headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
      let body = JSON.stringify(JSONdata)
console.log(body);
      return this.http
      .post(url, body, { })
      .catch(this.handleError);
    } 
    getFriendList(url: string, userId
      ): Observable<any>
    {
      let JSONdata = {
        "UserID": userId        
      }
    //  let headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
      let body = JSON.stringify(JSONdata)
console.log(body);
      return this.http
      .post(url, body, { })
      .catch(this.handleError);
    } 
    saveChatData(url: string,msg, userId,friendId
      ): Observable<any>
    {
      let JSONdata = {
        "msg":msg,
        "UserID": userId,
        "FriendID":friendId        
      }
    //  let headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
      let body = JSON.stringify(JSONdata)
console.log(body);
      return this.http
      .post(url, body, { })
      .catch(this.handleError);
    } 

    chatList(url: string, userId,friendId
      ): Observable<any>
    {
      let JSONdata = {
         "UserID": userId,
        "FriendID":friendId        
      }
    //  let headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
      let body = JSON.stringify(JSONdata)
console.log(body);
      return this.http
      .post(url, body, { })
      .catch(this.handleError);
    } 

}
