import {Component, OnInit, ViewEncapsulation} from '@angular/core';

export interface Tile {
    color: string;
    cols: number;
    rows: number;
    text: string;
}

@Component({
  selector: 'app-site-layout',
  templateUrl: './site-layout.component.html',
  encapsulation: ViewEncapsulation.None,
  styleUrls: ['./site-layout.component.scss']
})
export class SiteLayoutComponent implements OnInit {
    tiles: Tile[] = [
        {text: 'One', cols: 1, rows: 2, color: 'lightblue'},
        {text: 'Two', cols: 2, rows: 1, color: 'lightgreen'},
        {text: 'Three', cols: 2, rows: 1, color: 'lightpink'},
    ];
  constructor() { }

  ngOnInit() {

  }

}
