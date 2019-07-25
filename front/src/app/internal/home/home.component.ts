import { Component, OnInit } from '@angular/core';
import {UserService} from "../user/user.service";
import {CoreService} from "../../core.service";

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss']
})
export class HomeComponent implements OnInit {

  constructor(private coreService: CoreService, private userService: UserService) { }

  ngOnInit() {
      var logg =JSON.parse(localStorage.getItem('currentUser'));
      if(!logg.user) {
          this.coreService.get(`user/get-identity`).subscribe(result => {
              console.log(result);
              logg.user = result;
              localStorage.setItem('currentUser', JSON.stringify(logg));
              this.userService.setProfiles(logg.user.profiles);
          })
      }
  }

}
