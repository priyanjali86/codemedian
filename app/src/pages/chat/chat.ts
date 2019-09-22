import { Component, ElementRef, ViewChild } from '@angular/core';
import { IonicPage, NavParams,NavController } from 'ionic-angular';
import { Events, Content } from 'ionic-angular';
import { interval } from 'rxjs/observable/interval';
import { AppServiceProvider } from '../../providers/app-service/app-service';
@IonicPage()
@Component({
  selector: 'page-chat',
  templateUrl: 'chat.html',
})
export class Chat {

  @ViewChild(Content) content: Content;
  @ViewChild('chat_input') messageInput: ElementRef;
  msgList :any;
  //user: UserInfo;
  toUser: any;
  editorMsg = '';
  showEmojiPicker = false;
  toUserId;
  UserId;
  activeStatus;
  constructor(navParams: NavParams,
             
              private events: Events, public appservice: AppServiceProvider, public navCtrl: NavController) {
    // Get the navParams toUserId parameter
    
    this.toUser = {
      id: navParams.get('UserID'),
      name: navParams.get('Full_Name')
    };
    this.toUserId=navParams.get('UserID');
    interval(10000).subscribe(x =>this.getMsg())
    console.log(navParams.get('UserID'));
    console.log(navParams.get('Full_Name'));
    
    // Get mock user information
    // this.chatService.getUserInfo()
    // .then((res) => {
    //   this.user = res
    // });
    this.UserId=localStorage.getItem('user_id');
  }

  // ionViewWillLeave() {
    
  //   // unsubscribe
  //   this.events.unsubscribe('chat:received');
  // }

  ionViewDidEnter() {
    
    console.log(localStorage.getItem('userImg'));
    //get message list
    this.getMsg();
   
    // Subscribe to received  new message events
    // this.events.subscribe('chat:received', msg => {
    //   this.getMsg();
    //   //this.pushNewMsg(msg);
    // })
  }

  // onFocus() {
  //   this.showEmojiPicker = false;
  //   this.content.resize();
  //   this.scrollToBottom();
  // }

  switchEmojiPicker() {
    this.showEmojiPicker = !this.showEmojiPicker;
    if (!this.showEmojiPicker) {
    //  this.focus();
    } else {
      this.setTextareaScroll();
    }
    this.content.resize();
    this.content.scrollToBottom();
  }

  /**
   * @name getMsg
   * @returns {Promise<ChatMessage[]>}
   */
  getMsg() {
    // Get mock message list
    this.content.scrollToBottom();
    this.appservice.chatList(this.appservice.BASE_URL + '/getChatList', localStorage.getItem('user_id'),this.toUser.id).subscribe(res => {
     if(res[0].ChatList!=null)
     {
      this.msgList=res[0].ChatList;
      for(let i=0;i<res[0].ChatList.length;i++)
      {
        if(res[0].ChatList[i].userAvatar!=null&&res[0].ChatList[i].userAvatar!=''&&res[0].ChatList[i].userAvatar!=undefined)
        {
          this.msgList[i].userAvatar=this.appservice.BASE_URL+''+res[0].ChatList[i].userAvatar;
        }
        else
        {
          this.msgList[i].userAvatar=this.appservice.BASE_URL+'../../assets/imgs/profile-image.jpg';
        }
       
       }
     }
     else
     {
      this.msgList='';
     }
     

     
      console.log( this.msgList);
    
     
       });

    // return this.chatService
    // .getMsgList()
    // .subscribe(res => {
    //   this.msgList = res;
    //   this.scrollToBottom();
    // });
  }

  /**
   * @name sendMsg
   */

   
  sendMsg() {
    if (!this.editorMsg.trim()) return;

    // Mock message
    //const id = Date.now().toString();
if(this.editorMsg!=null&&this.editorMsg!=undefined&&this.editorMsg!='')
{
    let newMsg = {
      messageId: Date.now().toString(),
      userId: localStorage.getItem('user_id'),
      userName: localStorage.getItem('userName'),
      userAvatar: localStorage.getItem('userImg'),
      toUserId: this.toUser.id,
      toUserName:this.toUser.name,
      time: Date.now(),
      message: this.editorMsg,
      status: 'pending'
    };
    console.log(newMsg);
  //  let loadingPop = this.appservice.createLoadingBar();
   // loadingPop.present();
    this.appservice.saveChatData(this.appservice.BASE_URL + '/saveChat',newMsg,localStorage.getItem('user_id'),this.toUser.id).subscribe(res => {
   
      if (res[0].ServiceStatus === 1) {
        this.getMsg();
        //loadingPop.dismiss();
      }
     // console.log(res[0].ChatList);
   // this.navCtrl.pop();
setTimeout(() => {  
// this.pushNewMsg(newMsg);
  this.editorMsg = '';
  this.content.scrollToBottom();
  // if (!this.showEmojiPicker) {
  //   this.focus();
  // }
}, 300);
    
   
    });

  }
  }

  
  pushNewMsg(msg) {
    this.msgList.push(msg);
    console.log(msg);
    const userId = this.UserId,
      toUserId = this.toUser.id;
    // Verify user relationships
    if (msg.userId === userId && msg.toUserId === toUserId) {
      this.msgList.push(msg);
    } else if (msg.toUserId === userId && msg.userId === toUserId) {
      this.msgList.push(msg);
    }


  


   // this.content.scrollToBottom();
  }

  getMsgIndexById(id: string) {
    return this.msgList.findIndex(e => e.messageId === id)
  }

  // scrollToBottom() {
  //   setTimeout(() => {
  //     if (this.content.scrollToBottom) {
  //       this.content.scrollToBottom();
  //     }
  //   }, 400)
  // }

  // private focus() {
  //   if (this.messageInput && this.messageInput.nativeElement) {
  //     this.messageInput.nativeElement.focus();
  //   }
  // }

  private setTextareaScroll() {
    const textarea =this.messageInput.nativeElement;
    textarea.scrollTop = textarea.scrollHeight;
  }
}
