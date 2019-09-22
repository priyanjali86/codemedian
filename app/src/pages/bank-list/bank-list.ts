import { Component } from '@angular/core';
import { NavController, NavParams, ActionSheetController } from 'ionic-angular';
import { ModalController } from 'ionic-angular';
import { BankDetailPage } from '../bank-detail/bank-detail';


/**
 * Generated class for the BankListPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@Component({
  selector: 'page-bank-list',
  templateUrl: 'bank-list.html',
})
export class BankListPage {

  constructor(public navCtrl: NavController, public navParams: NavParams, public modalCtrl: ModalController) {
  }

  ionViewDidLoad() {
    console.log('ionViewDidLoad BankListPage');
  }

  bankDetailModal() {
    let option = { enableBackdropDismiss: false, cssClass: "modal-style" };
    let profileModal = this.modalCtrl.create(BankDetailPage, option);
    profileModal.onDidDismiss(() => {


    });
    profileModal.present();

  }

}
