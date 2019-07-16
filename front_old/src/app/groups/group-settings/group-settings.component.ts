import {Component, OnInit} from '@angular/core';
import {FormBuilder, FormGroup, FormControl, Validators} from '@angular/forms';
import {GroupsService} from "../groups.service";

@Component({
    selector: 'app-group-settings',
    templateUrl: './group-settings.component.html',
    styleUrls: ['./group-settings.component.scss']
})
export class GroupSettingsComponent implements OnInit {

    groupSettingsForm: FormGroup;

    validateFormControl = new FormControl('', [
        Validators.required,
        Validators.email,
    ]);


    constructor(private formBuilder: FormBuilder, private groupService: GroupsService) {
    }

    ngOnInit() {
        this.groupSettingsForm = this.formBuilder.group({
            name: ['', Validators.required],
            description: ['']
        });
    }

}
