import { Component, OnInit } from '@angular/core';
import {FormBuilder, FormGroup, FormControl, Validators} from "@angular/forms";
import {GroupsService} from "../groups.service";

@Component({
  selector: 'app-groups-settings',
  templateUrl: './groups-settings.component.html',
  styleUrls: ['./groups-settings.component.scss']
})
export class GroupsSettingsComponent implements OnInit {

    groupSettingsForm: FormGroup;

    validateFormControl = new FormControl('', [
        Validators.required,
        Validators.email,
    ]);

  constructor(private formBuilder: FormBuilder, private groupService: GroupsService) { }

    ngOnInit() {
        this.groupSettingsForm = this.formBuilder.group({
            name: ['', Validators.required],
            description: ['']
        });
    }

}
