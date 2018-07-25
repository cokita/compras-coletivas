import { Component, OnInit } from '@angular/core';

import {MatInputModule} from '@angular/material/input';

imports: [ MatInputModule ]

@Component({
  selector: 'app-user',
  templateUrl: './user.component.html',
  styleUrls: ['./user.component.scss']
})
export class UserComponent implements OnInit {

  constructor() { }

  ngOnInit() {
  }

}
