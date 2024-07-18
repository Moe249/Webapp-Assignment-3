import { PdfReader } from "pdfreader";

export function readPDFFile(path) {
    new PdfReader().parseFileItems(path, function (err, item) {
        if (item && item.text) {
            console.log(item.text);
            return item.text;
        }
    });
}