import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams } from 'ionic-angular';
import { ModalController } from 'ionic-angular';
import { SelectBankPage } from '../select-bank/select-bank';

/**
 * Generated class for the WalletPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@IonicPage()
@Component({
  selector: 'page-wallet',
  templateUrl: 'wallet.html',
})
export class WalletPage {

  constructor(public navCtrl: NavController, public navParams: NavParams,public modalCtrl: ModalController) {
  }

  ionViewDidLoad() {
    console.log('ionViewDidLoad WalletPage');
  }

  selectBank()
  {
    
    
      let option = { enableBackdropDismiss: false, cssClass: "modal-style" };
      let profileModal = this.modalCtrl.create(SelectBankPage, option);
      profileModal.onDidDismiss(() => {
  
        this.navCtrl.push(WalletPage);
      });
      profileModal.present();
  
  
  
  
  
      // const modal = this.modalCtrl.create(BankDetailPage,{ cssClass: "modal-fullscreen" });
      // modal.present();
    
  }
  

}
