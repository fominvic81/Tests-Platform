import React, { useState } from 'react';
import { EditorContent, useEditor, Editor, ChainedCommands } from '@tiptap/react'
import ListItem from '@tiptap/extension-list-item';
import { Color } from '@tiptap/extension-color';
import TextStyle from '@tiptap/extension-text-style';
import StarterKit from '@tiptap/starter-kit';
import Placeholder from '@tiptap/extension-placeholder';
import Subscript from '@tiptap/extension-subscript';
import Superscript from '@tiptap/extension-superscript';
import Underline from '@tiptap/extension-underline';

interface MenuButtonProps extends React.PropsWithChildren {
    editor: Editor;
    action: (chain: ChainedCommands) => ChainedCommands;
    name?: string;
}

const MenuButton: React.FC<MenuButtonProps> = ({ editor, action, children, name }) => {

    return <button type='button' 
        onClick={() => action(editor.chain().focus()).run()}
        disabled={!action(editor.can().chain().focus()).run()}
        className={`px-2 mx-1 rounded ${name && editor.isActive(name) ? 'font-bold bg-gray-200' : 'bg-gray-50'}`}>{ children }</button>
}

interface MenuBarProps {
    editor: Editor;
}

const MenuBar: React.FC<MenuBarProps> = ({ editor }) => {

    return (
        <div className='bg-gray-50 border-2 border-b-0 p-2 '>
            <MenuButton editor={ editor } action={(chain) => chain.toggleBold()} name='bold'>B</MenuButton>
            <MenuButton editor={ editor } action={(chain) => chain.toggleItalic()} name='italic'>I</MenuButton>
            <MenuButton editor={ editor } action={(chain) => chain.toggleStrike()} name='strike'>S</MenuButton>
            <MenuButton editor={ editor } action={(chain) => chain.toggleUnderline()} name='underline'>U</MenuButton>
            <MenuButton editor={ editor } action={(chain) => chain.toggleBulletList()} name='bulletList'>-</MenuButton>
            <MenuButton editor={ editor } action={(chain) => chain.toggleOrderedList()} name='orderedList'>1</MenuButton>
            <MenuButton editor={ editor } action={(chain) => chain.toggleCodeBlock()} name='codeBlock'>C</MenuButton>
            <MenuButton editor={ editor } action={(chain) => chain.toggleBlockquote()} name='blockquote'>q</MenuButton>
            <MenuButton
                editor={ editor }
                action={(chain) => {
                    chain.unsetSubscript();
                    return chain.toggleSuperscript();
                }}
                name='superscript'
            >2</MenuButton>
            <MenuButton
                editor={ editor }
                action={(chain) => {
                    chain.unsetSuperscript();
                    return chain.toggleSubscript();
                }}
                name='subscript'
            >s</MenuButton>
            <MenuButton editor={ editor } action={(chain) => chain.setHorizontalRule()}>H</MenuButton>
            <MenuButton editor={ editor } action={(chain) => chain.setHardBreak()}>N</MenuButton>
            <MenuButton editor={ editor } action={(chain) => chain.undo()} name='undo'>U</MenuButton>
            <MenuButton editor={ editor } action={(chain) => chain.redo()} name='redo'>R</MenuButton>
            <MenuButton editor={ editor } action={(chain) => editor.isActive('textStyle', { color: '#958DF1' }) ? chain.unsetColor() : chain.setColor('#958DF1')}>P</MenuButton>
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
