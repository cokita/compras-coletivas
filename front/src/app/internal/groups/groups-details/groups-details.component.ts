import { Component, OnInit } from '@angular/core';
import {GroupsService} from "../groups.service";
import {ActivatedRoute} from "@angular/router";

@Component({
  selector: 'app-groups-details',
  templateUrl: './groups-details.component.html',
  styleUrls: ['./groups-details.component.scss']
})
export class GroupsDetailsComponent implements OnInit {
  groupId: Integer;
  group:any = null;
  constructor(private groupService: GroupsService, private _route: ActivatedRoute) { }

  ngOnInit() {
      this.groupId = this._route.snapshot.paramMap.get('id');
      this.groupService.show(this.groupId, {with: 'image,user'}).subscribe(result => {
          this.group = result;
      });
  }

}
