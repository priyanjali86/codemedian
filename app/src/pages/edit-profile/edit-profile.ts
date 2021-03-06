import { Component } from '@angular/core';
import { NavController, NavParams, ActionSheetController } from 'ionic-angular';
import { ModalController } from 'ionic-angular';
import { BankDetailPage } from '../bank-detail/bank-detail';
import { AppServiceProvider } from '../../providers/app-service/app-service';
import { Camera, CameraOptions } from '@ionic-native/camera';
import { ViewProfilePage } from '../view-profile/view-profile';

/**
 * Generated class for the EditProfilePage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

// @IonicPage()
// @Component({
//   selector: 'page-edit-profile',
//   templateUrl: 'edit-profile.html',
// })
// export class EditProfilePage {

//   constructor(public navCtrl: NavController, public navParams: NavParams) {
//   }

//   ionViewDidLoad() {
//     console.log('ionViewDidLoad EditProfilePage');
//   }

// }

@Component({
  selector: 'page-edit-profile',
  templateUrl: 'edit-profile.html',
})
export class EditProfilePage {
  editForm: any = {};
  bankName: any;
  accountNumber: any;
  isImageSelected: any;
  showImage: any;
  isUpdate: any = "0";
  constructor(private camera: Camera, public actionSheetCtrl: ActionSheetController, public navCtrl: NavController, public navParams: NavParams, public modalCtrl: ModalController, public appservice: AppServiceProvider) {
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
        this.editForm.userId = localStorage.getItem('user_id');
        this.editForm.phone = res[0].MobileNumber;
        this.editForm.email = res[0].EmailAddress;
        this.editForm.fullname = res[0].FullName;
        this.editForm.address = res[0].Address;
        this.editForm.RelationshipStatus = res[0].RelationshipStatus;
        this.editForm.dob = res[0].DOB;
        if (res[0].ProfilePicturePath != '') {
          this.editForm.images = res[0].ProfilePicturePath;
          this.editForm.isUpdate = "0";
        }
        else {
          this.editForm.images = '../../assets/imgs/profile-image.jpg';
          this.editForm.isUpdate = "0";
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

  editProfile() {

    let loadingPop = this.appservice.createLoadingBar();
    loadingPop.present();
    this.appservice.profileSave(this.appservice.BASE_URL + '/UserProfileSave', this.editForm).subscribe(res => {
      console.log(res);
      if (res[0].ServiceStatus === 1) {
        loadingPop.dismiss();
        this.navCtrl.pop();
       // this.navCtrl.setRoot(ViewProfilePage);
        //this.getProfile();
        console.log(this.editForm);
        this.appservice.presentToast(res[0].ReturnMessage)
        this.editForm.useId = localStorage.getItem('user_id');
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

  bankDetailModal() {
    let option = { enableBackdropDismiss: false, cssClass: "modal-style" };
    let profileModal = this.modalCtrl.create(BankDetailPage, option);
    profileModal.onDidDismiss(() => {


    });
    profileModal.present();





    // const modal = this.modalCtrl.create(BankDetailPage,{ cssClass: "modal-fullscreen" });
    // modal.present();
  }
  /* Function name: presentActionSheet()
  Description: This function is to present action sheet for taking taking place image 
  ========================== start ================================ */
  presentActionSheet() {
    let actionSheet = this.actionSheetCtrl.create({
      title: 'Choose image source',
      buttons: [
        {
          text: 'Gallery',
          //role: 'destructive',
          icon: 'image',
          handler: () => {
            const options: CameraOptions = {
              quality: 50,
              destinationType: this.camera.DestinationType.DATA_URL,
              encodingType: this.camera.EncodingType.JPEG,
              mediaType: this.camera.MediaType.PICTURE,
              sourceType: 0,
              correctOrientation: true,
              allowEdit: true
            };
            this.camera.getPicture(options).then((imageData) => {
              console.log(imageData);

              this.showImage = 'data:image/png;base64,' + imageData;
              this.editForm.images = this.showImage;
              this.editForm.isUpdate = "1";
              this.isImageSelected = true;
            }, (err) => {
            });
          }
        }, 
        {
          text: 'Camera',
          //role: 'destructive',
          icon: 'camera',
          handler: () => {
            const options: CameraOptions = {
              quality: 50,
              destinationType: this.camera.DestinationType.DATA_URL,
              encodingType: this.camera.EncodingType.JPEG,
              mediaType: this.camera.MediaType.PICTURE,
              sourceType: 1,
              correctOrientation: true,
              cameraDirection: 1,
              allowEdit: true
            };
            this.camera.getPicture(options).then((imageData) => {
              console.log(imageData);

              this.showImage = 'data:image/png;base64,' + imageData;
              this.editForm.images = this.showImage;
              this.editForm.isUpdate = "1";
              this.isImageSelected = true;
            }, (err) => {
            });





          }
        }, {
          text: 'Cancel',
          icon: 'close-circle',
          role: 'cancel',
          handler: () => {
          }
        }


      ]
    });
    actionSheet.present();
  }
  /*============== presentActionSheet() end ===================*/
}
