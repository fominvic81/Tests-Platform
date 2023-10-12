/// <reference types="vite-plugin-svgr/client" />

import React, { useState } from 'react';
import { EditorContent, useEditor, Editor, ChainedCommands } from '@tiptap/react';
import ListItem from '@tiptap/extension-list-item';
import { Color } from '@tiptap/extension-color';
import TextStyle from '@tiptap/extension-text-style';
import StarterKit from '@tiptap/starter-kit';
import Placeholder from '@tiptap/extension-placeholder';
import Subscript from '@tiptap/extension-subscript';
import Superscript from '@tiptap/extension-superscript';
import Underline from '@tiptap/extension-underline';

import BoldSVG from '../../../svg/editor/bold.svg?react';
import ItalicSVG from '../../../svg/editor/italic.svg?react';
import StrikeSVG from '../../../svg/editor/strike.svg?react';
import UnderlineSVG from '../../../svg/editor/underline.svg?react';
import OrderedListSVG from '../../../svg/editor/list-ordered.svg?react';
import UnorderedListSVG from '../../../svg/editor/list-unordered.svg?react';
import CodeSVG from '../../../svg/editor/code.svg?react';
import QuoteSVG from '../../../svg/editor/quote.svg?react';
import SuperScriptSVG from '../../../svg/editor/super-script.svg?react';
import SubScriptSVG from '../../../svg/editor/sub-script.svg?react';

import Undo from '../../../svg/editor/undo.svg?react';

interface MenuButtonProps extends React.PropsWithChildren {
    editor: Editor;
    action: (chain: ChainedCommands) => ChainedCommands;
    name?: string;
}

const MenuButton: React.FC<MenuButtonProps> = ({ editor, action, children, name }) => {

    return <button type='button' 
        onClick={() => action(editor.chain().focus()).run()}
        disabled={!action(editor.can().chain().focus()).run()}
        className={`mx-1 p-1 w-6 h-6 rounded ${name && editor.isActive(name) ? 'font-bold bg-gray-200' : 'bg-gray-50'}`}>{ children }</button>
}

interface MenuBarProps {
    editor: Editor;
}

const MenuBar: React.FC<MenuBarProps> = ({ editor }) => {

    return (
        <div className='bg-gray-50 border-2 border-b-0 p-2 flex items-center'>
            <MenuButton editor={ editor } action={(chain) => chain.toggleBold()} name='bold'><BoldSVG className='w-full h-full'></BoldSVG></MenuButton>
            <MenuButton editor={ editor } action={(chain) => chain.toggleItalic()} name='italic'><ItalicSVG className='w-full h-full'></ItalicSVG></MenuButton>
            <MenuButton editor={ editor } action={(chain) => chain.toggleStrike()} name='strike'><StrikeSVG className='w-full h-full'></StrikeSVG></MenuButton>
            <MenuButton editor={ editor } action={(chain) => chain.toggleUnderline()} name='underline'><UnderlineSVG className='w-full h-full'></UnderlineSVG></MenuButton>
            <MenuButton editor={ editor } action={(chain) => chain.toggleBulletList()} name='bulletList'><UnorderedListSVG className='w-full h-full'></UnorderedListSVG></MenuButton>
            <MenuButton editor={ editor } action={(chain) => chain.toggleOrderedList()} name='orderedList'><OrderedListSVG className='w-full h-full'></OrderedListSVG></MenuButton>
            <MenuButton editor={ editor } action={(chain) => chain.toggleCodeBlock()} name='codeBlock'><CodeSVG className='w-full h-full'></CodeSVG></MenuButton>
            <MenuButton editor={ editor } action={(chain) => chain.toggleBlockquote()} name='blockquote'><QuoteSVG className='w-full h-full'></QuoteSVG></MenuButton>
            <MenuButton
                editor={ editor }
                action={(chain) => {
                    chain.unsetSubscript();
                    return chain.toggleSuperscript();
                }}
                name='superscript'
            ><SuperScriptSVG className='w-full h-full'></SuperScriptSVG></MenuButton>
            <MenuButton
                editor={ editor }
                action={(chain) => {
                    chain.unsetSuperscript();
                    return chain.toggleSubscript();
                }}
                name='subscript'
            ><SubScriptSVG className='w-full h-full'></SubScriptSVG></MenuButton>
            {/* <MenuButton editor={ editor } action={(chain) => chain.setHorizontalRule()}>H</MenuButton>
            <MenuButton editor={ editor } action={(chain) => chain.setHardBreak()}>N</MenuButton>
            <MenuButton editor={ editor } action={(chain) => chain.undo()} name='undo'><Undo className='w-full h-full'></Undo></MenuButton>
            <MenuButton editor={ editor } action={(chain) => chain.redo()} name='redo'><Undo className='w-full h-full -scale-x-100'></Undo></MenuButton>
            <MenuButton editor={ editor } action={(chain) => editor.isActive('textStyle', { color: '#958DF1' }) ? chain.unsetColor() : chain.setColor('#958DF1')}>P</MenuButton> */}
        </div>
    )
}

interface Props {
    name: string;
    id: string;
    defaultValue?: string;
    placeholder?: string;
}

export const EditorComponent: React.FC<Props> = ({ name, id, defaultValue, placeholder }) => {
    const [value, setValue] = useState(defaultValue ?? '');

    const editor = useEditor({
        editorProps: {
            attributes: {
                class: 'bg-gray-50 border-2 p-1',
            },
        },
        onUpdate: ({ editor }) => setValue(editor.getHTML()),
        extensions: [
            Color.configure({ types: [TextStyle.name, ListItem.name] }),
            // @ts-ignore
            TextStyle.configure({ types: [ListItem.name] }),
            StarterKit.configure({
                bulletList: {
                    keepMarks: true,
                    keepAttributes: false, // TODO : Making this as `false` becase marks are not preserved when I try to preserve attrs, awaiting a bit of help
                },
                orderedList: {
                    keepMarks: true,
                    keepAttributes: false, // TODO : Making this as `false` becase marks are not preserved when I try to preserve attrs, awaiting a bit of help
                },
            }),
            Placeholder.configure({
                placeholder,
            }),
            Underline.configure(),
            Superscript.configure(),
            Subscript.configure(),
        ],
        content: value,
    });
    if (!editor) return;

    return <div className='break-words'>
        <input type='hidden' name={ name } id={ id } value={ value }></input>
        <MenuBar editor={editor}></MenuBar>
        <EditorContent editor={editor}></EditorContent>
    </div>;
}
