import { NgModule } from '@angular/core';
import { IonicPageModule } from 'ionic-angular';
import { BankDetailPage } from './bank-detail';

@NgModule({
  declarations: [
    BankDetailPage,
  ],
  imports: [
    IonicPageModule.forChild(BankDetailPage),
  ],
})
export class BankDetailPageModule {}
