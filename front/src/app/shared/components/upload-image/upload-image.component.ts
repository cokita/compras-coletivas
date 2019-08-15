import {Component, ElementRef, EventEmitter, Input, OnInit, Output, ViewChild} from '@angular/core';

@Component({
    selector: 'app-upload-image',
    templateUrl: './upload-image.component.html',
    styleUrls: ['./upload-image.component.scss']
})
export class UploadImageComponent implements OnInit {
    @ViewChild('fileInput', {static: true}) fileInput: ElementRef;
    imagePreview: any = null;
    imagePreviewSrc: any = null;
    imageCopy: any = null;
    @Input() image;
    @Output() imageOutput = new EventEmitter();

    constructor() {
    }

    ngOnInit() {
        this.imageCopy = this.image;
    }

    onFileChange(event) {
        console.log(this.fileInput);
        if (event.target.files.length > 0) {
            let file = event.target.files[0];
            this.imagePreview = file;
            this.imageCopy = null;
            const reader = new FileReader();
            reader.onload = e => this.imagePreviewSrc = reader.result;

            reader.readAsDataURL(file);
            this.imageOutput.emit(file);
        }
    }

    clearFile() {
        this.imagePreview = null;
        this.imageCopy = this.image;
        this.imagePreviewSrc = null;
        if (this.fileInput && this.fileInput.nativeElement) { // this validation fixes the issue
            this.fileInput.nativeElement.value = '';
        }
        this.imageOutput.emit(null);
    }

}
