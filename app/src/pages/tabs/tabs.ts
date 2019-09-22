import { Component } from '@angular/core';
import { AboutPage } from '../about/about';
import { HomePage } from '../home/home';
import { ProfilePage } from '../profile/profile';
import { BankDetailPage } from '../bank-detail/bank-detail';
import { LoginPage } from '../login/login';
import {ViewProfilePage} from '../view-profile/view-profile';
import {EditProfilePage} from '../edit-profile/edit-profile';
import { ContactPage } from '../contact/contact'; 
import { FriendListPage } from '../friend-list/friend-list';

@Component({
  templateUrl: 'tabs.html'
})
export class TabsPage {

  tab1Root = HomePage;
  tab2Root = FriendListPage;
  tab3Root = AboutPage;
  tab4Root = ProfilePage;

  constructor() {

  }
}
