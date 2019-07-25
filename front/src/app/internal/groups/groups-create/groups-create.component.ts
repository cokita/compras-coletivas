import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, FormControl, Validators } from '@angular/forms';

@Component({
  selector: 'app-groups-create',
  templateUrl: './groups-create.component.html',
  styleUrls: ['./groups-create.component.scss']
})
export class GroupsCreateComponent implements OnInit {

    groupForm: FormGroup;

    validateFormControl = new FormControl('', [
        Validators.required,
        Validators.email,
    ]);
  constructor(private formBuilder: FormBuilder) {
      this.groupForm = this.formBuilder.group({
          name: ['', Validators.required],
          description: [],
          image: []
      });
  }

  ngOnInit() {
  }

  save(){

  }
}
