import { Component, OnInit } from '@angular/core';
import {LoginService} from "../../../external/login/login.service";

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.scss']
})
export class HeaderComponent implements OnInit {

  constructor(private loginService: LoginService) { }

  ngOnInit() {
  }

  logout(){
    this.loginService.logout();
  }

}
