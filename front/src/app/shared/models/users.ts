import {Files} from "./files";

export class User {
    constructor(public id: number,
                public name: string,
                public email?: string,
                public cellphone?: string,
                public cpf?: string,
                public gender?: string,
                public birthday?: string,
                public active?: boolean,
                public file_id?: number,
                public file?: Files) {}
}

export interface Users {
    id: number;
    name: string;
    email: string;
    cellphone: string;
    cpf: string;
    gender: string;
    birthday: string;
    active: boolean;
    file_id: number;
    file: Files
}
