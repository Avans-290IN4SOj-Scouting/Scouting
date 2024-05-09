import {HSSelect} from "/preline";

const el = HSSelect.getInstance('#select');

el.on('change', (val) => console.log('success'));
