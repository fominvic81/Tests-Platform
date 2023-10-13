// import React from 'react';
// import { TextEditor } from '../TextEditor';


// export const Option = () => {
//     return <>
//         <input type='hidden' name={ `options[${index}][id]` } value={ option.id } />
//         <TextEditor
//             name={`options[${index}][text]`}
//             placeholder='Варіант'
//             defaultValue={ option.text }
//             onChange={(value) => onChangeValue(index, 'text', value)}
//         ></TextEditor>
//         <div className='w-40'></div>
//         <button
//             type='button'
//             className='w-8 aspect-square bg-red-600 rounded disabled:bg-gray-600'
//             disabled={ options.length <= 2 }
//             onClick={() => {
//                 console.log(index);
//                 setOptions(options.filter((v, idx) => index !== idx))
//             }}
//         >D</button>
//     </>
// }