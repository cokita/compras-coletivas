import { Component, OnInit } from '@angular/core';
import {FormBuilder, FormGroup, FormControl, Validators} from "@angular/forms";
import {GroupsService} from "../groups.service";
import {ActivatedRoute} from "@angular/router";
import {Observable, of} from "rxjs/index";
import {Users} from "../../../shared/models/users";
import {UserService} from "../../user/user.service";
import {catchError, debounceTime, map, startWith, switchMap} from "rxjs/internal/operators";

@Component({
  selector: 'app-groups-settings',
  templateUrl: './groups-settings.component.html',
  styleUrls: ['./groups-settings.component.scss']
})
export class GroupsSettingsComponent implements OnInit {
    groupId: any;
    group:any = null;
    groupSettingsForm: FormGroup;
    newImage = null;
    filteredUsers: any;
    noimage: string = '../../../assets/images/noprofile.png';
    users: any = [];
    displayedColumns: string[] = ['#','Nome', 'E-mail', 'Celular'];
    columns: string[] = ['file','name', 'email', 'cellphone'];

    validateFormControl = new FormControl('', [
        Validators.required,
        Validators.email,
    ]);

  constructor(private formBuilder: FormBuilder, private groupService: GroupsService, private _route: ActivatedRoute,
              private userService: UserService) { }

    ngOnInit() {
        this.groupSettingsForm = this.formBuilder.group({
            name: ['', Validators.required],
            description: [''],
            tempUser: ['']
        });
        this.groupId = this._route.snapshot.paramMap.get('id');
        this.groupService.show(this.groupId, {'with': 'image,user'}).subscribe(result => {
            this.group = result;
            this.groupSettingsForm.patchValue({name: this.group.name, description: this.group.description});
        });

        this.filteredUsers = this.f.tempUser.valueChanges.pipe(
            startWith(''),
            debounceTime(500),
            switchMap(value => {
                if (value !== null && value !== '' && value.length >= 3) {
                    return this.lookup(value);
                } else {
                    return of(null);
                }
            })
        );

    }
    get f() { return this.groupSettingsForm.controls; }

    reciverImage(event){
      this.newImage = event;
    }

    userSelected(event){
        this.users.push(event.option.value);
        // this.groupSettingsForm.setValue({tempUser:null});
        this.groupSettingsForm.controls['tempUser'].setValue(null);

    }

    private prepareSave(): any {
        const formData = new FormData();
        formData.append('user_id', this.f.user_id.value.id);
        formData.append('name', this.f.name.value);
        formData.append('description', this.f.description.value);
        if(this.newImage){
            formData.append('image', this.newImage);
        }
        return formData;
    }

    lookup(value: string): Observable<Users> {
        return this.userService.search({name: value, with:'file'}).pipe(
            map(results => results),
            // catch errors
            catchError(_ => {
                return of(null);
            })
        );
    }

}
