import {Component, ChangeDetectorRef, ElementRef, HostListener, OnInit, ViewChild} from '@angular/core';
import {FormBuilder, FormGroup, FormControl, Validators} from '@angular/forms';
import {Users} from "../../../shared/models/users";
import {map, startWith, tap, switchMap, debounceTime,catchError} from 'rxjs/operators';
import {Observable, observable, of} from 'rxjs';
import {UserService} from "../../user/user.service";
import {CoreService} from "../../../core.service";
import {GroupsService} from "../groups.service";
import {MatSnackBar} from "@angular/material";
import {Router} from "@angular/router";


@Component({
    selector: 'app-groups-create',
    templateUrl: './groups-create.component.html',
    styleUrls: ['./groups-create.component.scss'],

})
export class GroupsCreateComponent implements OnInit {
    @ViewChild('fileInput',{static: true}) fileInput: ElementRef;

    groupForm: FormGroup;
    validateFormControl = new FormControl('', [
        Validators.required,
        Validators.email,
    ]);
    filteredSellers: any;
    oldSeller: any = null;
    imagePreview: any = null;
    imagePreviewSrc: any = null;
    formdata: FormData;
    noimage: string = '../../../assets/images/noprofile.png';



    constructor(private formBuilder: FormBuilder,private cd: ChangeDetectorRef, private userService: UserService,
                private groupService: GroupsService) {
    }

    ngOnInit() {
        this.groupForm = this.formBuilder.group({
            name: ['', Validators.required],
            description: [],
            user_id: ['', Validators.required]
        });

        this.filteredSellers = this.f.user_id.valueChanges.pipe(
            startWith(''),
            debounceTime(500),
            switchMap(value => {
                if (value !== '' && value.length >= 3 && this.oldSeller == null) {
                    return this.lookup(value);
                } else {
                    this.oldSeller = null;
                    // if no value is pressent, return null
                    return of(null);
                }
            })
        );

    }

    lookup(value: string): Observable<Users> {
        return this.userService.search({name: value, with:'file'}).pipe(
            // map the item property of the github results as our return object
            map(results => results),
            // catch errors
            catchError(_ => {
                return of(null);
            })
        );
    }

    get f() { return this.groupForm.controls; }


    save() {
        const formModel = this.prepareSave();
        this.groupService.create(formModel).add(result => {
            console.log(result);
        });
    }

    displayFn(user: Users) {
        if (user) {
            return user.name;
        }
    }

    sellerSelected(event){
        this.oldSeller = event.option.value;
    }

    private prepareSave(): any {
            console.log(this.fileInput);
        const formData = new FormData();
        formData.append('user_id', this.f.user_id.value.id);
        formData.append('name', this.f.name.value);
        formData.append('description', this.f.description.value);
        formData.append('image', this.imagePreview);
        return formData;
    }

    onFileChange(event) {
            console.log(this.fileInput);
        if(event.target.files.length > 0) {
            let file = event.target.files[0];
            this.imagePreview = file;
            const reader = new FileReader();
            reader.onload = e => this.imagePreviewSrc = reader.result;

            reader.readAsDataURL(file);
        }
    }

    clearFile() {
        console.log(this.fileInput);
        this.imagePreview = null;
        this.imagePreviewSrc = null;
        if (this.fileInput && this.fileInput.nativeElement) { // this validation fixes the issue
            this.fileInput.nativeElement.value = '';
        }
    }

}
