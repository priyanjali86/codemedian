import { Component } from '@angular/core';
import {  NavController, NavParams } from 'ionic-angular';

/**
 * Generated class for the BankDetailPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */


@Component({
  selector: 'page-bank-detail',
  templateUrl: 'bank-detail.html',
})
export class BankDetailPage {
editForm:any={};
  constructor(public navCtrl: NavController, public navParams: NavParams) {
      this.editForm.bankName=localStorage.getItem('BankName');
      this.editForm.bankHolderName=localStorage.getItem('BankHolderName');

      this.editForm.accountType=localStorage.getItem('AccountType');
      this.editForm.accountNumber=localStorage.getItem('AccountNumber');
      this.editForm.IFSCCode=localStorage.getItem('IFSCCode');
  }

  ionViewDidLoad() {
    console.log('ionViewDidLoad BankDetailPage');
  }
  closeModal()
  {
    this.navCtrl.pop();
  }
  addBank()
  {
    localStorage.setItem('BankName',this.editForm.bankName);
            localStorage.setItem('BankHolderName',this.editForm.bankHolderName);

            localStorage.setItem('AccountType',this.editForm.accountType);
            localStorage.setItem('AccountNumber',this.editForm.accountNumber);
            localStorage.setItem('IFSCCode',this.editForm.IFSCCode);
            this.navCtrl.pop();
  }
 

}
