import { NgModule, ErrorHandler } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { IonicApp, IonicModule, IonicErrorHandler } from 'ionic-angular';
import { MyApp } from './app.component';

import { AboutPage } from '../pages/about/about';
import { ContactPage } from '../pages/contact/contact';
import { HomePage } from '../pages/home/home';
import { TabsPage } from '../pages/tabs/tabs';
import { HttpClientModule } from '@angular/common/http';

import { StatusBar } from '@ionic-native/status-bar';
import { SplashScreen } from '@ionic-native/splash-screen';
import { LoginPage } from '../pages/login/login';
import { AppServiceProvider } from '../providers/app-service/app-service';
import { ProfilePage } from '../pages/profile/profile';
import { BankDetailPage } from '../pages/bank-detail/bank-detail';
import { SignupPage } from '../pages/signup/signup';
import { ViewProfilePage } from '../pages/view-profile/view-profile';
import {EditProfilePage} from '../pages/edit-profile/edit-profile';
import { Camera } from '@ionic-native/camera';
import { FriendListPage } from '../pages/friend-list/friend-list';
import { FriendProfilePage } from '../pages/friend-profile/friend-profile';
import { HistoryPage } from '../pages/history/history';
import { WalletPage } from '../pages/wallet/wallet';
import { SelectBankPage } from '../pages/select-bank/select-bank';
import { BankListPage } from '../pages/bank-list/bank-list';
import { EmojiProvider } from '../providers/emoji';
import { UserListPage } from '../pages/user-list/user-list';
import { FriendRequestPage } from '../pages/friend-request/friend-request';

@NgModule({
  declarations: [
    MyApp,
    AboutPage,
    ContactPage,
    HomePage,
    TabsPage,
    LoginPage,
    ProfilePage,
    BankDetailPage,
    SignupPage,
    ViewProfilePage,
    EditProfilePage,
    FriendListPage,
    FriendProfilePage,
    HistoryPage,
    WalletPage,
    SelectBankPage,
    BankListPage,
    UserListPage,
    FriendRequestPage
  ],
  imports: [
    BrowserModule,HttpClientModule,
    IonicModule.forRoot(MyApp)
  ],
  bootstrap: [IonicApp],
  entryComponents: [
    MyApp,
    AboutPage,
    ContactPage,
    HomePage,
    TabsPage,
    LoginPage,
    ProfilePage,
    BankDetailPage,
    SignupPage,
    ViewProfilePage,
    EditProfilePage,
    FriendListPage,
    FriendProfilePage,
    HistoryPage,
    WalletPage,
    SelectBankPage,
    BankListPage,
    UserListPage,
    FriendRequestPage
  ],
  providers: [
    StatusBar,
    SplashScreen,
    Camera,
    {provide: ErrorHandler, useClass: IonicErrorHandler},    
    AppServiceProvider,
    EmojiProvider
  ]
})
export class AppModule {}
