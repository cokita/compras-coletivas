import { Component, OnInit } from '@angular/core';
import * as moment from 'moment/moment';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent implements OnInit {
  title = 'app';

    ngOnInit() {
        moment().locale('pt-br');

        window.onbeforeunload = function(evt) {
        }
    }
}
