import { Component, OnInit } from '@angular/core';
import { GroupsService } from "./groups.service";


@Component({
  selector: 'app-groups',
  templateUrl: './groups.component.html',
  styleUrls: ['./groups.component.scss']
})
export class GroupsComponent implements OnInit {
  protected myGroups:Array<object>;
  constructor(private groupService: GroupsService) { }

  ngOnInit() {
    this.groupService.getMyGroups().subscribe(result => {
      this.myGroups = result;
console.log(this.myGroups);
    });

  }

}
