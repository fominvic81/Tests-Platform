// import React, { PropsWithChildren, Ref, useMemo } from 'react';
// import { createEditor, Descendant, Editor } from 'slate';
// import { Slate, Editable, withReact, useSlate } from 'slate-react';

// const initialValue: Descendant[] = [
//     {
//         children: [
//             { text: 'This is editable plain text, just like a <textarea>!' },
//         ],
//     },
// ];

// export const EditorComponent: React.FC = () => {
//     const editor = useMemo(() => withReact(createEditor()), []);
    

//     return <Slate editor={ editor } initialValue={initialValue} onChange={(value) => {
//         console.log(value);
//     }}>
//         <Editable className='border bg-gray-50 p-1'></Editable>
//     </Slate>
// }
import React, { useMemo, useState } from 'react';
import ReactQuill from 'react-quill';
// import 'react-quill/dist/react-quill';
import 'react-quill/dist/quill.snow.css';
import Quill from 'quill';

const colors = [
    '#000000', '#e60000', '#ff9900', '#ffff00', '#008a00', '#0066cc', '#9933ff', 
    '#ffffff', '#facccc', '#ffebcc', '#ffffcc', '#cce8cc', '#cce0f5', '#ebd6ff',
    '#bbbbbb', '#f06666', '#ffc266', '#ffff66', '#66b966', '#66a3e0', '#c285ff',
    '#888888', '#a10000', '#b26b00', '#b2b200', '#006100', '#0047b2', '#6b24b2',
    '#444444', '#5c0000', '#663d00', '#666600', '#003700', '#002966', '#3d1466',
];

interface Props {
    name: string;
    id: string;
}

export const EditorComponent: React.FC<Props> = ({ name, id }) => {

    const [value, setValue] = useState('');
    const modules = useMemo(() => ({
        toolbar: {
            container: `#${id}-toolbar`,
            handlers: {},
        },
    }), []);

    return <>
        <input type='hidden' name={ name } id={ id } value={ value }></input>
        <div className='bg-gray-50 border'>
            <div id={`${id}-toolbar`}>
                <span className='ql-formats'>
                    <button className='ql-bold' />
                    <button className='ql-italic' />
                    <button className='ql-underline' />
                    <button className='ql-strike' />
                </span>

                <span className='ql-formats'>
                    <button className='ql-list' value='ordered' />
                    <button className='ql-list' value='bullet' />
                </span>

                <span className='ql-formats'>
                    <button className='ql-script' value='sub'></button>
                    <button className='ql-script' value='super'></button>
                </span>

                <span className='ql-formats'>
                    <select className='ql-color'>{ colors.map((value) => <option value={value}></option>) }</select>
                    <select className='ql-background'>{ colors.map((value) => <option value={value}></option>) }</select>
                </span>

                <span className='ql-formats'>
                    <select className='ql-align'>
                        <option selected></option>
                        <option value='center'></option>
                        <option value='justify'></option>
                        <option value='right'></option>
                    </select>
                </span>

                <span className='ql-formats'>
                    <button className='ql-clean'></button>
                </span>

                <span className='ql-formats'>
                    <button className='ql-link'></button>
                </span>
            </div>
            <ReactQuill modules={modules} theme='snow' value={value} onChange={setValue}></ReactQuill>
        </div>
    </>
}