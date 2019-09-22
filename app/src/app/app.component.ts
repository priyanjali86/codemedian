import { Component,ViewChild } from '@angular/core';
import { Platform, Nav } from 'ionic-angular';
import { StatusBar } from '@ionic-native/status-bar';
import { SplashScreen } from '@ionic-native/splash-screen';

import { LoginPage } from '../pages/login/login';
import { ProfilePage } from '../pages/profile/profile';
import { HomePage } from '../pages/home/home';
import { TabsPage } from '../pages/tabs/tabs';
import { ViewProfilePage } from '../pages/view-profile/view-profile';
import { EditProfilePage } from '../pages/edit-profile/edit-profile';
import { FriendListPage } from '../pages/friend-list/friend-list';
import { FriendProfilePage } from '../pages/friend-profile/friend-profile';
import { HistoryPage } from '../pages/history/history';
import { WalletPage } from '../pages/wallet/wallet';
import { SelectBankPage } from '../pages/select-bank/select-bank';
import { BankListPage } from '../pages/bank-list/bank-list';

@Component({
  templateUrl: 'app.html'
})
export class MyApp {
  @ViewChild(Nav) nav: Nav;
  rootPage:any ;
  pages: Array<{title: string, component: any}>
  //rootPage: any=TabsPage;
  constructor(platform: Platform, statusBar: StatusBar, splashScreen: SplashScreen,) {
   

    this.pages = [
      { title: 'Home', component: TabsPage }
    ];
    platform.ready().then(() => {
      if (localStorage.getItem('user_id') != '' && localStorage.getItem('user_id') != null && localStorage.getItem('user_id') != undefined) {
        this.rootPage = TabsPage;
      }
      else {
        this.rootPage = LoginPage;
      }
      statusBar.overlaysWebView(false);
      statusBar.backgroundColorByHexString('#CCCCCC');
      statusBar.styleLightContent();
      // Okay, so the platform is ready and our plugins are available.
      // Here you can do any higher level native things you might need.
      statusBar.styleDefault();
      splashScreen.hide();
    });
  }
  openPage(page) {
    // Reset the content nav to have just this page
    // we wouldn't want the back button to show in this scenario
    this.nav.setRoot(page.component);
  }


}
