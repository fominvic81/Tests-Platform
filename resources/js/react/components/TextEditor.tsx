/// <reference types="vite-plugin-svgr/client" />

import React, { useEffect, useState } from 'react';
import { EditorContent, useEditor, Editor, ChainedCommands } from '@tiptap/react';
import ListItem from '@tiptap/extension-list-item';
import { Color } from '@tiptap/extension-color';
import TextStyle from '@tiptap/extension-text-style';
import StarterKit from '@tiptap/starter-kit';
import Placeholder from '@tiptap/extension-placeholder';
import Subscript from '@tiptap/extension-subscript';
import Superscript from '@tiptap/extension-superscript';
import Underline from '@tiptap/extension-underline';

import BoldSVG from '../../../svg/text-editor/bold.svg?react';
import ItalicSVG from '../../../svg/text-editor/italic.svg?react';
import StrikeSVG from '../../../svg/text-editor/strike.svg?react';
import UnderlineSVG from '../../../svg/text-editor/underline.svg?react';
import OrderedListSVG from '../../../svg/text-editor/list-ordered.svg?react';
import UnorderedListSVG from '../../../svg/text-editor/list-unordered.svg?react';
import CodeSVG from '../../../svg/text-editor/code.svg?react';
import QuoteSVG from '../../../svg/text-editor/quote.svg?react';
import SuperScriptSVG from '../../../svg/text-editor/super-script.svg?react';
import SubScriptSVG from '../../../svg/text-editor/sub-script.svg?react';

import Undo from '../../../svg/text-editor/undo.svg?react';

interface MenuButtonProps extends React.PropsWithChildren {
    editor: Editor;
    action: (chain: ChainedCommands) => ChainedCommands;
    name?: string;
}

const MenuButton: React.FC<MenuButtonProps> = ({ editor, action, children, name }) => {

    return <button type='button' 
        onClick={() => action(editor.chain().focus()).run()}
        disabled={!action(editor.can().chain().focus()).run()}
        className={`mx-1 p-1 w-full aspect-square rounded ${name && editor.isActive(name) ? 'bg-gray-200' : 'bg-white'}`}>{ children }</button>
}

interface MenuBarProps {
    editor: Editor;
}

const MenuBar: React.FC<MenuBarProps> = ({ editor }) => {

    return (
        <div className='border-2 border-b-0 p-2 grid grid-cols-[repeat(auto-fill,24px)]'>
            <MenuButton editor={ editor } action={(chain) => chain.toggleBold()} name='bold'><BoldSVG></BoldSVG></MenuButton>
            <MenuButton editor={ editor } action={(chain) => chain.toggleItalic()} name='italic'><ItalicSVG></ItalicSVG></MenuButton>
            <MenuButton editor={ editor } action={(chain) => chain.toggleStrike()} name='strike'><StrikeSVG></StrikeSVG></MenuButton>
            <MenuButton editor={ editor } action={(chain) => chain.toggleUnderline()} name='underline'><UnderlineSVG></UnderlineSVG></MenuButton>
            <MenuButton editor={ editor } action={(chain) => chain.toggleBulletList()} name='bulletList'><UnorderedListSVG></UnorderedListSVG></MenuButton>
            <MenuButton editor={ editor } action={(chain) => chain.toggleOrderedList()} name='orderedList'><OrderedListSVG></OrderedListSVG></MenuButton>
            <MenuButton editor={ editor } action={(chain) => chain.toggleCodeBlock()} name='codeBlock'><CodeSVG></CodeSVG></MenuButton>
            <MenuButton editor={ editor } action={(chain) => chain.toggleBlockquote()} name='blockquote'><QuoteSVG></QuoteSVG></MenuButton>
            <MenuButton
                editor={ editor }
                action={(chain) => {
                    chain.unsetSubscript();
                    return chain.toggleSuperscript();
                }}
                name='superscript'
            ><SuperScriptSVG></SuperScriptSVG></MenuButton>
            <MenuButton
                editor={ editor }
                action={(chain) => {
                    chain.unsetSuperscript();
                    return chain.toggleSubscript();
                }}
                name='subscript'
            ><SubScriptSVG></SubScriptSVG></MenuButton>
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
    id?: string;
    value?: string;
    defaultValue?: string;
    placeholder?: string;
    onChange?: (value: string) => any;
}

export const TextEditor: React.FC<Props> = ({ name, id, value, defaultValue, placeholder, onChange }) => {
    const [currentValue, setCurrentValue] = useState(value ?? defaultValue ?? '');
    const updateValue = (newValue: string) => {
        setCurrentValue(newValue);
        if (!editor) return;
        editor.commands.setContent(newValue);
    }

    const editor = useEditor({
        editorProps: {
            attributes: {
                class: 'bg-white border-2 p-1',
            },
        },
        onUpdate: ({ editor }) => {
            const html = editor.getHTML();
            if (value) {
                updateValue(value);
            } else {
                setCurrentValue(html);
            }
            if (onChange) onChange(html);
        },
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
        content: currentValue,
    });

    useEffect(() => {
        if (!editor) return;
        updateValue(value ?? '');
    }, [value]);

    if (!editor) return;

    return <div className='overflow-hidden break-words rounded'>
        <input type='hidden' name={ name } id={ id } value={ currentValue }></input>
        <MenuBar editor={ editor }></MenuBar>
        <EditorContent editor={ editor }></EditorContent>
    </div>;
}
