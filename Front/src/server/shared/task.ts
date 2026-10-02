import { Entity } from "remult";

@Entity("tasks",{allowApiCrud: true})
export class Task{
    id=0;
    title='';
    completed=false;
}

